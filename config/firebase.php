<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Firebase Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Firebase Firestore Database Connection
    |
    */

    'project_id' => env('FIREBASE_PROJECT_ID', 'interlink-11d80'),
    
    'api_key' => env('FIREBASE_API_KEY', ''),
    
    'auth_domain' => env('FIREBASE_AUTH_DOMAIN', ''),
    
    'database_url' => env('FIREBASE_DATABASE_URL', ''),
    
    'storage_bucket' => env('FIREBASE_STORAGE_BUCKET', ''),
    
    'messaging_sender_id' => env('FIREBASE_MESSAGING_SENDER_ID', ''),
    
    'app_id' => env('FIREBASE_APP_ID', ''),
    
    'measurement_id' => env('FIREBASE_MEASUREMENT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Service Account JSON
    |--------------------------------------------------------------------------
    |
    | Path to your Firebase service account JSON file
    | Download from: https://console.firebase.google.com/project/{PROJECT}/settings/serviceaccounts/adminsdk
    |
    */
    'credentials' => env('FIREBASE_CREDENTIALS_PATH', storage_path('firebase/service-account.json')),

    /*
    |--------------------------------------------------------------------------
    | Firestore Collection Names
    |--------------------------------------------------------------------------
    |
    | Define the collection names for your data
    |
    */
    'collections' => [
        'users' => 'users',
        'ojt_documents' => 'ojt_documents',
        'weekly_journals' => 'weekly_journals',
        'time_logs' => 'time_logs',
        'competency_evaluations' => 'competency_evaluations',
    ],
];
