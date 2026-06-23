<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Factory;
use Kreait\Firestore\DocumentReference;
use Kreait\Firestore\DocumentSnapshot;

class FirestoreUser
{
    /**
     * Document reference in Firestore
     */
    protected DocumentReference $reference;

    /**
     * User data
     */
    protected array $data = [];

    /**
     * Document ID (user ID)
     */
    protected string $documentId;

    /**
     * User attributes that can be filled
     */
    protected array $fillable = [
        'name',
        'email',
        'password',
        'role',
        'teacher_id',
        'supervisor_id',
        'company_name',
        'department',
        'required_hours',
        'phone',
        'created_at',
        'updated_at',
    ];

    /**
     * Initialize Firestore connection
     */
    protected static function getFirestore()
    {
        $factory = new Factory();
        $serviceAccountPath = config('firebase.credentials');

        if (file_exists($serviceAccountPath)) {
            $factory = $factory->withServiceAccount($serviceAccountPath);
        }

        return $factory->createFirestore()->database();
    }

    /**
     * Create a new Firestore user instance
     */
    public function __construct(array $data = [], string $documentId = '')
    {
        $this->data = $data;
        $this->documentId = $documentId;

        if ($documentId) {
            $this->reference = self::getFirestore()
                ->collection(config('firebase.collections.users'))
                ->document($documentId);
        }
    }

    /**
     * Create a new user in Firestore
     */
    public static function create(array $data): self
    {
        $firestore = self::getFirestore();
        $usersCollection = $firestore->collection(config('firebase.collections.users'));

        // Hash password if provided
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        // Generate unique document ID
        $documentId = $data['email'] ?? Str::uuid()->toString();

        // Add timestamps
        $data['created_at'] = now()->toIso8601String();
        $data['updated_at'] = now()->toIso8601String();

        // Create document
        $usersCollection->document($documentId)->set($data);

        return new self($data, $documentId);
    }

    /**
     * Find user by email
     */
    public static function findByEmail(string $email): ?self
    {
        $firestore = self::getFirestore();
        $usersCollection = $firestore->collection(config('firebase.collections.users'));

        $documents = $usersCollection
            ->where('email', '==', $email)
            ->limit(1)
            ->documents();

        foreach ($documents as $document) {
            if ($document->exists()) {
                return new self($document->data(), $document->id());
            }
        }

        return null;
    }

    /**
     * Find user by ID
     */
    public static function find(string $id): ?self
    {
        $firestore = self::getFirestore();
        $usersCollection = $firestore->collection(config('firebase.collections.users'));
        $document = $usersCollection->document($id)->snapshot();

        if ($document->exists()) {
            return new self($document->data(), $document->id());
        }

        return null;
    }

    /**
     * Find user by email and role
     */
    public static function findByEmailAndRole(string $email, string $role): ?self
    {
        $firestore = self::getFirestore();
        $usersCollection = $firestore->collection(config('firebase.collections.users'));

        $documents = $usersCollection
            ->where('email', '==', $email)
            ->where('role', '==', $role)
            ->limit(1)
            ->documents();

        foreach ($documents as $document) {
            if ($document->exists()) {
                return new self($document->data(), $document->id());
            }
        }

        return null;
    }

    /**
     * Update user
     */
    public function update(array $data): bool
    {
        $data['updated_at'] = now()->toIso8601String();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $this->reference->update(
            array_map(fn($value, $key) => [
                'path' => $key,
                'value' => $value,
            ], $data, array_keys($data))
        );

        $this->data = array_merge($this->data, $data);

        return true;
    }

    /**
     * Delete user
     */
    public function delete(): bool
    {
        $this->reference->delete();
        return true;
    }

    /**
     * Get all users with optional filtering
     */
    public static function all(array $filters = []): array
    {
        $firestore = self::getFirestore();
        $query = $firestore->collection(config('firebase.collections.users'));

        // Apply filters
        foreach ($filters as $field => $value) {
            $query = $query->where($field, '==', $value);
        }

        $documents = $query->documents();
        $users = [];

        foreach ($documents as $document) {
            if ($document->exists()) {
                $users[] = new self($document->data(), $document->id());
            }
        }

        return $users;
    }

    /**
     * Get all users by role
     */
    public static function findByRole(string $role): array
    {
        return self::all(['role' => $role]);
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->data['password'] ?? '');
    }

    /**
     * Get user attribute
     */
    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }

    /**
     * Set user attribute
     */
    public function __set($key, $value)
    {
        if (in_array($key, $this->fillable)) {
            $this->data[$key] = $value;
        }
    }

    /**
     * Check if attribute exists
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * Get document ID
     */
    public function getId(): string
    {
        return $this->documentId;
    }

    /**
     * Get all data as array
     */
    public function toArray(): array
    {
        return array_merge($this->data, ['id' => $this->documentId]);
    }

    /**
     * Get data as JSON
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
