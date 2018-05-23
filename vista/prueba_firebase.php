<?php
    require $_SERVER['DOCUMENT_ROOT'].'/RoofAdvisor/vendor/autoload.php';

    use Kreait\Firebase\Factory;
    use Kreait\Firebase\ServiceAccount;

    // This assumes that you have placed the Firebase credentials in the same directory
    // as this PHP file.
    $serviceAccount = ServiceAccount::fromJsonFile($_SERVER['DOCUMENT_ROOT'].'/RoofAdvisor/vendor/pruebabasedatos-eacf6-firebase.json');

    $firebase = (new Factory)
        ->withServiceAccount($serviceAccount)
        // The following line is optional if the project id in your credentials file
        // is identical to the subdomain of your Firebase project. If you need it,
        // make sure to replace the URL with the URL of your project.
        ->withDatabaseUri('https://pruebabasedatos-eacf6.firebaseio.com')
        ->create();

    $database = $firebase->getDatabase();


    // ok $reference = $database->getReference('Company/CO000001');
    // ok $reference = $database->getReference('Company');
    //$reference = $database->getReference('Company/CO000001');
    //$snapshot = $reference->getSnapshot();
    //$value = $snapshot->getValue();

    $snapshot=$database->getReference('Customers')
    // order the reference's children by their key in ascending order
    ->shallow()
    ->getSnapshot();
    $value = $snapshot->getValue();
    print_r($value);
    echo "<br><br>";
    $value=$database->getReference('Company')->getChildKeys();

    print_r($value);

    echo "<br><br> Filtrado";
    $snapshot=$database->getReference('Company')
    // order the reference's children by the values in the field 'height'
    ->orderByChild('CompanyEmail')
    // returns all persons being exactly 1.98 (meters) tall
    ->equalTo('Lpernia@gemini.com')
    ->getSnapshot();

    $value = $snapshot->getValue();
    print_r($value);

    $database->getReference('Company/website')
    ->set([
       'name' => 'My Application',
       'emails' => [
           'support' => 'support@domain.tld',
           'sales' => 'sales@domain.tld',
       ],
       'website' => 'https://app.domain.tld',
      ]);

      echo "se inserto<br><br>";

      $auth = $firebase->getAuth();
      //$user = $auth->getUser('ZbX8JzRpRiSx6AYNu3g4ouKAKA13');
      //echo "usuario <br>";

      //print_r($user);

      $userProperties = [
        'email' => 'mauricio.rincon@gmail.com',
        'emailVerified' => false,
        'phoneNumber' => '+15555550100',
        'password' => 'secretPassword',
        'displayName' => 'John Doe',
        'photoUrl' => 'http://www.example.com/12345678/photo.png',
        'disabled' => false,
    ];
    echo "crear usuario<br><br>";
    //$createdUser = $auth->createUser($userProperties);
    
    $user = $auth->getUser('D7BAuXfiPuhtoCXtz5ScSFw3pRz1');
    echo "usuario:<br><br>";
    print_r($user);
    echo "<br><br>";
    //$auth->sendEmailVerification('D7BAuXfiPuhtoCXtz5ScSFw3pRz1');
    
    print_r($createdUser);

    echo "<br><br>";
    try {
        $user = $auth->verifyPassword('mauricio.rincon@gmail.com', 'secretPassword');
        echo "user logueado<br>";
        print_r($user);
    } catch (Kreait\Firebase\Exception\Auth\InvalidPassword $e) {
        echo $e->getMessage();
    }
    /*$newPost = $database
        ->getReference('Customers')
        ->push([
            'title' => 'Post title',
            'body' => 'This should probably be longer.'
        ]);*/
    
    
    //$newPost->getKey(); // => -KVr5eu8gcTv7_AHb-3-
    //$newPost->getUri(); // => https://my-project.firebaseio.com/blog/posts/-KVr5eu8gcTv7_AHb-3-

    
    //$newPost->getChild('title')->set('Changed post title');
    //$newPost->getValue(); // Fetches the data from the realtime database
    //echo "actulalizo eleemntos";
    //print_r($newPost);
    //$newPost->remove();
?>