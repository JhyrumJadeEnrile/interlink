# Firebase Firestore Setup Guide

## 📋 Setup Instructions

Your Firebase Firestore integration has been created with the following components:

### 1. **Configuration Files Created**
- `config/firebase.php` - Firebase configuration
- `app/Models/FirestoreUser.php` - Firestore User model with all methods
- `app/Http/Controllers/FirestoreAuthController.php` - Authentication controller
- `app/Services/FirebaseService.php` - Firebase service helper
- `app/Http/Middleware/FirestoreAuthenticated.php` - Authentication middleware

### 2. **Get Your Firebase Service Account Credentials**

1. Go to: https://console.firebase.google.com/project/interlink-11d80/settings/serviceaccounts/adminsdk
2. Click **"Generate new private key"**
3. Save the downloaded JSON file to: `storage/firebase/service-account.json`

### 3. **Create the Storage Directory**

```bash
mkdir storage/firebase
```

Then place your `service-account.json` file inside it.

### 4. **Update Your .env File**

The following have been added to your `.env`:
```
FIREBASE_PROJECT_ID=interlink-11d80
FIREBASE_API_KEY=your_api_key
FIREBASE_AUTH_DOMAIN=interlink-11d80.firebaseapp.com
FIREBASE_DATABASE_URL=https://interlink-11d80.firebaseio.com
FIREBASE_STORAGE_BUCKET=interlink-11d80.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your_sender_id
FIREBASE_APP_ID=your_app_id
FIREBASE_MEASUREMENT_ID=your_measurement_id
FIREBASE_CREDENTIALS_PATH=storage/firebase/service-account.json
```

Find these values in Firebase Console under **Project Settings** → **General** tab.

### 5. **Available User Fields in Firestore**

The FirestoreUser model automatically manages:
- `name` - User's full name
- `email` - Email address (used as document ID)
- `password` - Hashed password
- `role` - User role (student, coordinator, supervisor, admin)
- `teacher_id` - Optional teacher reference
- `supervisor_id` - Optional supervisor reference
- `company_name` - Company name (for supervisors)
- `department` - Department (for supervisors)
- `required_hours` - Required OJT hours
- `phone` - Phone number
- `created_at` - Auto-generated timestamp
- `updated_at` - Auto-updated timestamp

### 6. **Usage Examples**

#### Create a User
```php
use App\Models\FirestoreUser;

$user = FirestoreUser::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => 'password123',
    'role' => 'student',
    'required_hours' => 500,
]);
```

#### Find User by Email
```php
$user = FirestoreUser::findByEmail('john@example.com');
```

#### Find User by Email and Role
```php
$user = FirestoreUser::findByEmailAndRole('john@example.com', 'student');
```

#### Find User by ID
```php
$user = FirestoreUser::find('user_document_id');
```

#### Get All Users
```php
$users = FirestoreUser::all();
```

#### Get Users by Role
```php
$students = FirestoreUser::findByRole('student');
```

#### Update User
```php
$user->update([
    'name' => 'Jane Doe',
    'required_hours' => 600,
]);
```

#### Delete User
```php
$user->delete();
```

#### Access User Properties
```php
echo $user->name;
echo $user->email;
echo $user->role;
```

### 7. **Authentication Middleware**

Protect your routes with Firestore authentication:

```php
// In your routes/web.php
Route::middleware(['firestore-authenticated'])->group(function () {
    Route::get('/student/dashboard', function () {
        // Protected route
    });
});
```

Register middleware in `app/Http/Kernel.php`:
```php
protected $routeMiddleware = [
    // ... existing middleware
    'firestore-authenticated' => \App\Http\Middleware\FirestoreAuthenticated::class,
];
```

### 8. **Login/Register Routes**

The FirestoreAuthController provides these endpoints:

```php
// In routes/web.php
Route::get('/firestore/login/{role}', [FirestoreAuthController::class, 'showLoginForm']);
Route::post('/firestore/login/{role}', [FirestoreAuthController::class, 'login']);
Route::get('/firestore/register/{role}', [FirestoreAuthController::class, 'showRegisterForm']);
Route::post('/firestore/register/{role}', [FirestoreAuthController::class, 'register']);
Route::post('/firestore/logout', [FirestoreAuthController::class, 'logout']);
```

### 9. **Access Current User in Controller**

```php
use App\Http\Controllers\FirestoreAuthController;

$currentUser = FirestoreAuthController::getCurrentUser($request);
echo $currentUser->name; // Get user info
```

### 10. **Verify Password**

```php
if ($user->verifyPassword('password123')) {
    // Password is correct
}
```

## 🔧 Troubleshooting

- **"Service account file not found"** → Make sure the JSON file is in `storage/firebase/` directory
- **"Firestore connection failed"** → Verify your Firebase credentials are valid
- **"Collection not found"** → Collections are created automatically on first write

## 📚 Next Steps

1. Create login/register views using the Firestore controller
2. Test user creation with the `FirestoreUser::create()` method
3. Implement role-based access control (RBAC)
4. Add additional collections as needed in `config/firebase.php`
