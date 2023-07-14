<?php

$home = '/home/'.get_current_user();
$f3 = require($home.'/AboveWebRoot_pets/lib/base.php');

$f3->set('AUTOLOAD','autoload/;'.$home.'/AboveWebRoot_pets/autoload/');

$db = DatabaseConnection::connect();
$f3->set('DB', $db);
$f3->set('DEBUG',3);
$f3->set('UI','ui/');
$f3->set('UPLOADS', $home.'/AboveWebRoot/ServerImages/');

$f3->route('GET /',
    function ($f3)
    {
        $f3->set('html_title','Simple Example Home');
        $f3->set('header','Header.html');
        $f3->set('content','indexbeta.html');
        $f3->set('footer','Footer.html');

        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET /about',
    function($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','about.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout.html');;
    }
);

$f3->route('GET /cart',
    function($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','cart.html');
        $f3->set('footer','Footer.html');

        echo template::instance()->render('layout3.html');;
    }
);

function pprint_var($var)
{
    ob_start();
    var_dump($var);
    return ob_get_clean();
}

$f3->set('ONERROR', // what to do if something goes wrong.
    function($f3) {
        $f3->set('html_title',$f3['ERROR']['code']);
        $f3->set('DUMP', pprint_var($f3['ERROR']));
        $f3->set('content','error.html');
        echo template::instance()->render('layout.html');
    }
);
$test = $_SERVER['HOME'];

//quiz：
$f3->route('GET /simplequiz',
    function($f3) {
        $controller = new SimpleController3;
        $alldata = $controller->getQuiz();

        $f3->set("dbData", $alldata);
        $f3->set('html_title','Simple Quiz');
        $f3->set('header','Header.html');
        $f3->set('content', 'quiz1.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout3.html');
    }
);

$f3->route('POST /simplequiz',
    function($f3) {
        $controller = new SimpleController3;
        $alldata = $controller->getQuizVals();
        $markedAnswers = array();

        $counter = 0;
        $correctCounter = 0;
        $point= 0;

        /*var_dump($alldata);*/

        foreach ($alldata as $rowvals) {
            $counter++;
            $point += $rowvals['mark'.$f3->get('POST.q'.$counter)];
        }
        $f3->set('point', $point);

        if ($point > 0 && $point <=29) $targetRoom="OUTGOING";
        if ($point > 30 && $point <50) $targetRoom= "CAUTIOUS";
        if ($point > 51 && $point <=200) $targetRoom= "INTROVERTED";


        $f3->set('targetRoom', $targetRoom);

        $f3->set('markedAnswers', $markedAnswers);
        $f3->set('correctCounter', $correctCounter);
        $f3->set('totalCounter', $counter);

        $f3->set('html_title','Quiz Response');
        $f3->set('header','Header.html');
        $f3->set('content','quizresponseNew.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout3.html');
    }
);


$f3->route('POST /simplequizAdd',
    function($f3) {
        if ($f3->get('POST.question') != "") {
            $formdata = array();
            $formdata["question"] = $f3->get('POST.question');
            $formdata["a1"] = $f3->get('POST.a1');
            $formdata["a2"] = $f3->get('POST.a2');
            $formdata["a3"] = $f3->get('POST.a3');
            $formdata["a4"] = $f3->get('POST.a4');
            $formdata["correct"] = $f3->get('POST.correct');
            $formdata["image"] = $f3->get('POST.image');

            $controller = new SimpleController3;
            $controller->putIntoQuiz($formdata);

            echo "<h2>Quiz question added -- Thanks!</h2>" . "<p><a href='simplequizHome'>Home</a></p>";
        }
        else {
            echo "<h2>Empty quiz question: not accepted.</h2>" . "<p><a href='simplequizHome'>Home</a></p>";
        }
    }
);

$f3->route('GET|POST /image/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->showImage($f3->get('PARAMS.id'), false);
    }
);

$f3->route('GET|POST /thumb/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->showImage($f3->get('PARAMS.id'), true);
    }
);

$f3->route('GET /delete/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->deleteService($f3->get('PARAMS.id'));
        $f3->reroute('/viewimages');
    }
);

$f3->route('POST /delete/@id',
    function ($f3) {
        $is = new ImageServer;
        $is->deleteService($f3->get('PARAMS.id'));
    }
);

$f3->route('GET /shopbeta2',
    function ($f3) {
        $is = new ImageServer;
        $cate = $_GET['cate'] ? $_GET['cate'] : 1;
        $info = $is->getImageDataByCate($cate);
        //$info = $is->getAllImageData();
        $info3 = $is->test1(1);
        $f3->set('id5',$info3);

        $f3->set('datalist', $info);

        $f3->set('header','Header.html');
        $f3->set('footer','Footer.html');
            $f3->set('content', 'shopbeta2.html');

        echo template::instance()->render('layout3.html');
    }
);

$f3->route('POST /shopbeta2',
    function($f3)
    {
        $controller = new  ShopController2('picdata_fff');
        $data = $controller->findkeyword($f3->get('POST.keyword'));

        $f3->set('datalist', $data);
        $f3->set('html_title','Simple Example Response');
        $f3->set('header','Header.html');
        $f3->set('footer','Footer.html');
        $f3->set('content', 'shopbeta2.html');
        echo template::instance()->render('layout3.html');
    }
);

$f3->route('GET /product/@id',
    function ($f3) {
        $trueid = $f3->get('PARAMS.id');
        intval($trueid);
        $is = new ImageServer;
        $info = $is->test1($trueid);

        $is2 = new ImageServer2;
        $truetitle = $info->title;
        $newdata = $is2->findtitle($truetitle);

        $f3->set('datalist', $newdata);
        $f3->set('content','product11.html');
        echo template::instance()->render('product11.html');
    }
);

///login
$db = DatabaseConnection::connect();
$f3->set('DB', $db);

new \DB\SQL\Session($f3->get('DB'));
if (!$f3->exists('SESSION.userName')) $f3->set('SESSION.userName','UNSET');
//login

$f3->route('GET /login/@msg',
    function ($f3){
        switch ($f3->get('PARAMS.msg')){
            case "err":
                $msg="Wrong user name and/or password; please try again";
                break;
            case "lo":
                $msg="You have been logged out";
                break;
            default:
                $msg = "Login here";
        }
        $f3->set('html_title','Simple Login Form');
        $f3->set('message', $msg);
        $f3->set('content','indexlog.heml');
        $f3->set('thisIsLoginPage', 'true');

        echo template::instance()->render('indexlog.html');
    }
);
$f3->route('GET //login/@msg',
    function ($f3)
    {
        $f3->set('html_title','Simple Example Home');

        echo template::instance()->render('indexlog.html');
    }
);

$f3->route('POST /login',
    function ($f3) {$controller = new SimpleController('simpleUsers');
        if ($controller->loginUser($f3->get('POST.uname'), $f3->get('POST.password'))) {
            $f3->set('SESSION.userName', $f3->get('POST.uname'));
            $f3->set('html_title', 'Simple Input Form');
            echo template::instance()->render('addpic.html');
        } else
            $f3->rerooute('/login/err');
    }
);

$f3->route('GET /logout',
    function ($f3) {
        $f3->set('SESSION.userName', 'UNSET');
        header("Location: /shop4urPets/social");
        // $f3->reroute('/login');
    }
);

$f3->route('POST /regis',
    function($f3)
    {
        $formdata = array();			// array to pass on the entered data in
        $formdata["username"] = $f3->get('POST.username');			// whatever was called "name" on the form
        $formdata["password"] = $f3->get('POST.password');
        $controller = new  SimpleControllerNew('simpleUsers');
        $controller->putIntoDatabase($formdata);

        $f3->set('formData',$formdata);		// set info in F3 variable for access in response template
        $f3->set('html_title','Simple Example Response');
        $f3->set('content','successful.html');
        $f3->set('header','Header.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET /addpic',
    function ($f3) {
        // print_r($_SESSION['userName']);
        if (!$_SESSION['userName'] || $_SESSION['userName'] == 'UNSET') {
            echo "<script>
            alert('Please login first!');
            location.href='/shop4urPets/social';
            </script>";
            exit;
        }
        
        $f3->set('html_title', 'Image Server Home');
        $f3->set('content', 'addpic.html');
        echo template::instance()->render('addpic.html');
    }
);

$f3->route('GET /judgeLogin',
    function ($f3) {
        if (!$_SESSION['userName'] || $_SESSION['userName'] == 'UNSET') {
            echo 0;
        } else {
            echo 1;
        }
    }
);

$f3->route('GET /image',
    function ($f3) {
        $f3->set('html_title', 'Upload Image');
        $f3->set('content', 'upload.html');
        echo template::instance()->render('upload.html');
    }
);

$f3->route('GET /upload',
    function ($f3) {
        $f3->set('html_title', 'Image Server Upload');
        $f3->set('content', 'upload.html');
        echo template::instance()->render('upload.html');
    }
);

$f3->route('POST /upload',
    function ($f3) {
        $is = new ImageSocial;
        if ($filedata = $is->upload()) {
            $f3->set('filedata', $filedata);
            $f3->set('html_title', 'Image Server Home');
            $f3->set('content', 'successful2.html');
            $f3->set('header','Header.html');
            $f3->set('footer','Footer.html');
            echo template::instance()->render('layout.html');
        }
    }
);

$f3->route('GET|POST /upload/quiet',
    function ($f3) {
        $is = new ImageSocial;
        $filedata = $is->upload();
        echo json_encode($filedata);
    }
);

$f3->route('GET /uploaded',
    function ($f3) {
        $f3->set('html_title', 'Image Server Home');
        $f3->set('content', 'uploaded.html');
        echo template::instance()->render('uploaded.html');
    }
);

$f3->route('GET /infoservice',
    function ($f3) {
        $is = new ImageSocail;
        $info = $is->getAllImageData();
        echo json_encode($info);
    }
);

$f3->route('GET|POST /infoservice/@id',
    function ($f3) {
        $is = new ImageSocail;
        $info = $is->getImageData($f3->get('PARAMS.id'));
        echo json_encode($info);
    }
);

$f3->route('GET /social',
    function ($f3) {
        $is = new ImageSocial;
        $info = $is->getAllImageData();
        $f3->set('datalist', $info);
        $f3->set('header', 'Header.html');
        $f3->set('content', 'social.html');
        $f3->set('footer', 'Footer.html');
        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET|POST /image/@id',
    function ($f3) {
        $is = new ImageSocial;
        $is->showImage($f3->get('PARAMS.id'), false);
    }
);


$f3->route('GET|POST /thumb1/@id',
    function ($f3) {
        $is = new ImageSocail;
        $is->showImage($f3->get('PARAMS.id'), true);
    }
);

$f3->route('GET /delete/@id',
    function ($f3) {
        $is = new ImageSocial;
        $is->deleteService($f3->get('PARAMS.id'));
        $f3->reroute('/viewimages');
    }
);

$f3->route('POST /delete/@id',
    function ($f3) {
        $is = new ImageSocail;
        $is->deleteService($f3->get('PARAMS.id'));
    }
);

//letter
$f3->route('GET /showletter',
    function ($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','showletter.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout1.html');
    }
);

$f3->route('GET /message',
    function ($f3)
    {
        $f3->set('html_title','Simple Example Home');
        $f3->set('content','message.html');
                $f3->set('header','Header.html');
                $f3->set('footer','Footer.html');

        echo template::instance()->render('layout.html');
    }
);

$f3->route('GET /simpleform',
    function($f3)
    {
        $f3->set('html_title','Simple Input Form');
        $f3->set('header','Header.html');
        $f3->set('content','message.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout.html');
    }
);

$f3->route('POST /simpleform',
    function($f3)
    {

        $formdata = array();			// array to pass on the entered data in
        $formdata["name"] = $f3->get('POST.name');			// whatever was called "name" on the form
        $formdata["colour"] = $f3->get('POST.colour');		// whatever was called "colour" on the form
        $formdata["comment"] = $f3->get('POST.comment');
        $formdata["number"] = $f3->get('POST.number');
        $formdata["address1"] = $f3->get('POST.address1');
        $formdata["address2"] = $f3->get('POST.address2');
        $formdata["city"] = $f3->get('POST.city');
        $formdata["country"] = $f3->get('POST.country');
        $formdata["postcode"] = $f3->get('POST.postcode');
        $controller = new SimpleController('simpleModel');
        $controller->putIntoDatabase($formdata);
        $alldata = $controller->getData();
        rsort($alldata);
        $f3->set("dbData", $alldata);;


        $f3->set('html_title','Viewing the data');
        $f3->set('content','showletter.html');
        $f3->set('header','Header.html');
        $f3->set('footer','Footer.html');
        echo template::instance()->render('layout.html');

    }
);

//quiz123
$f3->route('GET /quizm1',
    function($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','quizm1.html');
        $f3->set('footer','Footer.html');

        echo template::instance()->render('layout2.html');;
    }
);

$f3->route('GET /quizm2',
    function($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','quizm2.html');
        $f3->set('footer','Footer.html');

        echo template::instance()->render('layout2.html');;
    }
);

$f3->route('GET /quizm3',
    function($f3)
    {
        $f3->set('header','Header.html');
        $f3->set('content','quizm3.html');
        $f3->set('footer','Footer.html');

        echo template::instance()->render('layout2.html');;
    }
);

// Run the FFF engine //
$f3->run();