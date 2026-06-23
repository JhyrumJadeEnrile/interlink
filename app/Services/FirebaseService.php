<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected static $instance = null;

    /**
     * Get Firebase instance
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            $factory = new Factory();
            $credentialsPath = config('firebase.credentials');

            if (file_exists($credentialsPath)) {
                $factory = $factory->withServiceAccount($credentialsPath);
            }

            self::$instance = $factory;
        }

        return self::$instance;
    }

    /**
     * Get Firestore database
     */
    public static function getFirestore()
    {
        return self::getInstance()->createFirestore()->database();
    }

    /**
     * Get Firebase Auth
     */
    public static function getAuth()
    {
        return self::getInstance()->createAuth();
    }

    /**
     * Get Firebase Storage
     */
    public static function getStorage()
    {
        return self::getInstance()->createStorage();
    }

    /**
     * Get Firebase Realtime Database
     */
    public static function getDatabase()
    {
        return self::getInstance()->createDatabase();
    }
}
