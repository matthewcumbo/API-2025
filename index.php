<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        
        // phpinfo();

        $curl = curl_init(); 

        curl_setopt($curl,CURLOPT_URL,"http://localhost:8888/api-2025/api/user/read");
        curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"GET");
        curl_setopt($curl,CURLOPT_HTTPHEADER,[
            "Accept" => "application/json",
            "Content-Type" => "application/json"
        ]);

        $result = curl_exec($curl);

        curl_close($curl);

        $result = json_decode($result,true);
        $data = $result["data"];
        // print_r($data);

        foreach($data as $user){
            echo "<h2>{$user["username"]}</h2>
            <p>
                {$user["firstName"]} 
                {$user["lastName"]}
            </p>";
            echo "<br><br>";
        }


        // insertUser("Create by consume API 2", "test2@create.com", "123", "Create", "from PHP Page");

        function insertUser($username, $email, $password, $firstName, $lastName){
            $curl = curl_init(); 

            curl_setopt($curl,CURLOPT_URL,"http://localhost:8888/api-2025/api/user/create");
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"POST");
            curl_setopt($curl,CURLOPT_HTTPHEADER,[
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]);
            curl_setopt($curl,CURLOPT_POSTFIELDS,'{
                "username" : "'.$username.'",
                "email" : "'.$email.'",
                "password" : "'.$password.'",
                "firstName" : "'.$firstName.'",
                "lastName" : "'.$lastName.'"
            }');

            $result = curl_exec($curl);

            curl_close($curl);

            $result = json_decode($result,true);
            // $data = $result["data"];

            print_r($result);
        }

        // deleteUser(3);

        function deleteUser($id){
            $curl = curl_init(); 

            curl_setopt($curl,CURLOPT_URL,"http://localhost:8888/api-2025/api/user/delete?id={$id}");
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl,CURLOPT_CUSTOMREQUEST,"DELETE");
            curl_setopt($curl,CURLOPT_HTTPHEADER,[
                "Accept" => "application/json",
                "Content-Type" => "application/json"
            ]);

            $result = curl_exec($curl);

            curl_close($curl);

            $result = json_decode($result,true);
        }
    ?>
</body>
</html>