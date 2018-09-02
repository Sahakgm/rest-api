<?php

require "vendor/autoload.php";
require "src/autoload.php";

use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    use Slim\Http\UploadedFile;

    $app = new \Slim\App();

    /**
     * mysite.local/user
     * shows the names of all users
     */
    $app->get('/user', function()
    {
        $conn = PDOConnection::getConnection();
        try{
            $sql = "SELECT name, surname FROM s_users WHERE user_status = 1";
            $result = $conn->query($sql) ;
            echo json_encode($result->fetchAll(PDO::FETCH_ASSOC));
        }catch (PDOException $e){
            die($e->getMessage());
        }
    });

    /**
     * mysite.local/user/{name}
     * shows user information
     */
    $app->get('/user/{name}', function(Request $request)
    {
        $name = $request->getAttribute('name');
        $conn = PDOConnection::getConnection();
        try{
            $stmt = $conn->prepare("SELECT * FROM s_users WHERE name=? ");
            $stmt->execute([$name]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC) ;

            if($data && $data['user_status'] == 1){
                $arr = array ('Name'=>$data['name'], 'Surname'=>$data['surname']);
                echo json_encode($arr);
            }else {
                echo 'User not found';
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
    });

    /**
     * Add new user
     * mysite.local/add
     * Param 1 - name
     * Param 2 - surname
     * Param 3 - password
     */
    $app->post('/add', function (Request $request)
    {
        if(empty($request->getParam('name')) || empty( $request->getParam('surname')) || empty($request->getParam('password'))){
            exit('error');
        }else{
            $u_name = $request->getParam('name');
            $surname = $request->getParam('surname');
            $pass = $request->getParam('password');
            $user_status = 1;
            $conn = PDOConnection::getConnection();
            $password =  password_hash($pass,PASSWORD_DEFAULT);
            try{
                $sql = "INSERT INTO s_users (name, surname, password, user_status)
                        VALUES(?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$u_name, $surname, $password, $user_status]);
                echo "User created";
            }catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    });

    /**
     * mysite.local/delete/
     * checks if user_status = 1, deletes
     * Param 1 - name
     */
    $app->delete('/delete/', function (Request $request)
    {
        $name = $request->getParam('name');
        $conn = PDOConnection::getConnection();
        try{
            $sql = "SELECT user_status FROM s_users WHERE name=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if($data['user_status'] == 1){
                $sql = "UPDATE s_users SET user_status=0 WHERE name=?";
                $stmt = $conn->prepare($sql);
                $stmt->execute([$name]);
                echo 'User deleted';
            }else{
                echo 'User not found';
            }
        }catch (PDOException $e){
            die($e->getMessage());
        }
    });

    /**
     * upload image
     * mysite.local/upload
     * param 1 - SELECT Image
     * PARAM 2 - SELECT User Name
     */
    $app->post('/upload', function(Request $request) use ($app)
    {
        $u_name = $request->getParam('name');
        $container = $app->getContainer();
        $container['upload_directory'] = realpath(__DIR__ . DIRECTORY_SEPARATOR .'..'.
        DIRECTORY_SEPARATOR .'..'. DIRECTORY_SEPARATOR .'uploads');
        $directory = $this->get('upload_directory');
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['image'];

        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = moveUploadedFile($directory, $uploadedFile);
        }
        $conn = PDOConnection::getConnection();
        $sql = "SELECT id FROM s_users WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$u_name]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC) ;

        if(!$result){
            exit("Error");
        }else{
            $u_id = $result['id'];
            $sql = "INSERT INTO photos (u_id, img) VALUES (:u_id, :filename)";
            $stmt =$conn->prepare($sql);
            $stmt->execute(array(
                       "u_id"=>$u_id,
                       "filename"=>$filename)
            );
            echo "image uploaded<br>";
        }
    });

    /**
     * @param $directory
     * @param UploadedFile $uploadedFile
     * @return string
     * @throws Exception
     */
    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);
        $filename = base64_encode($filename);
        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    };
    $app->map(['GET','POST','PUT','PATCH'], '/', function (){
        echo 'Home Page';
    });

    $app->run();
