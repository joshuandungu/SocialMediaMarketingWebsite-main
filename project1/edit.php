<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "orders";

$connection = new mysqli($servername, $username, $password, $database);

$username = "";
$pass = "";
$email = "";
$gender = "";
$platform = "";
$service = "";
$quantity = "";
$lang = "";
$screenshot = "";

$successMessage = "";
$errorMessage = "";

if($_SERVER['REQUEST_METHOD']== 'GET'){
    //SHOW DATA
    if(!isset($_GET['id'])){
        header("location: /SCS_Task/project1/order_history.php");
        exit;
    }
    $id = $_GET["id"];
    $sql = "SELECT * FROM orders WHERE id = $id";
    $result =$connection->query($sql);
    $row = $result->fetch_assoc();
    if(!$row){
        header("locaton: /SCS_Task/project1/order_history.php");
        exit;

    }
    $username = $row['username'];
    $pass= $row["pass"];
    $email= $row["email"];
    $gender = $row["gender"];
    $platform= $row["platform"];
    $service = $row["service"];
    $quantity = $row["quantity"];
    $lang = $row["lang"];
    $screenshot = "<img src='data:image/jpeg;base64," . base64_encode($row['screenshot']) . "' class='preview-image'>";
                // <th><img src='data:image/jpeg;base64," . base64_encode($row['screenshot']) . "' class='preview-image'></th>
}else{
    //Post update the data of the client
    $id = $_GET["id"];
    $sql = "SELECT * FROM orders WHERE id = $id";
    $result =$connection->query($sql);
    $row = $result->fetch_assoc();
    $username = $_POST['username'];
    $pass= $_POST["pass"];
    $email= $_POST["email"];
    $gender = $_POST["gender"];
    $platform= $_POST["platform"];
    $service = $_POST["service"];
    $quantity = $_POST["quantity"];
    $lang = $_POST["lang"];
    if (empty($_FILES["screenshot"]["tmp_name"]) || filesize($_FILES["screenshot"]["tmp_name"]) === 0) {
        $imageData = $row['screenshot'];
    } else {
        $screenshot = $_FILES["screenshot"]["tmp_name"];
        $imageData = file_get_contents($screenshot);
    }
    // if(empty(file_get_contents($_FILES["screenshot"]["tmp_name"]))){
    //     $imageData = $row['screenshot'];
    // }else{
    //     $screenshot = $_FILES["screenshot"]["tmp_name"];
    //     $imageData = file_get_contents($screenshot);
    // }
    do {

        if (empty($username) || empty($pass) || empty($email) || empty($gender) || empty($platform) || empty($service) || empty($quantity) || empty($lang) || empty($screenshot)) {
            $errorMessage = "All fields are required";
            break;
        }
       
        $sql = "UPDATE orders SET username=?, email=?, gender=?, platform=?, service=?, quantity=?, lang=?, screenshot=? WHERE id=?";
$stmt = $connection->prepare($sql);

// Check if the prepared statement was successfully created
if ($stmt) {
    $stmt->bind_param("ssssssssi", $username, $email, $gender, $platform, $service, $quantity, $lang, $imageData, $id);

    $result = $stmt->execute();

    if ($result) {
        $successMessage = "Order updated successfully";
        header("location:/SCS_Task/project1/order_history.php");
        exit;
    } else {
        $errorMessage = "Failed to update order: " . $stmt->error;
    }

    // Close the prepared statement
    $stmt->close();
} else {
    $errorMessage = "Failed to prepare the update statement: " . $connection->error;
}


    

    }while(false);
} 


?>









<!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src= "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">

        
    </script>


    <style>
        .form-container {
            margin: 50px auto;
            padding: 20px;
            width: 600px;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            margin-bottom: 10px;
        }

        #upload_btn,
        #delete_btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        #upload_btn:hover,
        #delete_btn:hover {
            background-color: #45a049;
        }

        #image_preview {
            max-width: 1000px;
            max-height: 1000px;
            overflow: auto;
        }

        .preview-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        #submit_btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
        }

        #submit_btn:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 5px;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container my-5">
        <h3 class="text-success text-center">UPDATE ORDER</h3>
        <?php  
        if(!empty($errorMessage)){
            echo "
            <div class = 'alert alert-warning alert-dismissible fade show' role = 'alert'>
                <strong>$errorMessage</Strong>
                <button type = 'button' class= 'btn-close' data-bs-dismiss = 'alert' aria-label= 'Close'></button>

            </div>
            ";
        }
        ?>
        <div class="form-container text-center">
            <input type="hidden" name = "id"value="<?php echo $id; ?>">
            <form id="myForm" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="user">Username:</label>
                    <div class="col-sm-6">
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="pwd">Password:</label>
                    <div class="col-sm-6">
                    <input type="password" name="pass" class="form-control" value="<?php echo $pass; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="email">Email:</label>
                    <div class="col-sm-6">
                    <input type="email" name="email" id="email" class="form-control" value="<?php echo $email; ?>">

                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Gender:</label>
                    <div class="col-sm-6">
                        <input type="radio" name="gender" id="male" value="male" <?php echo ($gender === 'male') ? 'checked' : ''; ?>>

                        <label for="male">Male</label>
                        <input type="radio" name="gender" id="female" value="female" <?php echo ($gender === 'female') ? 'checked' : ''; ?>>

                        <label for="female">Female</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="platform">Choose SMM Platform:</label>
                    <div class="col-sm-6">
                    <select class="form-control" id="platform" name="platform" onchange="myfun(this.value)">

                            <option value="">Select Platform</option>
                            <option value="FaceBook">Facebook</option>
                            <option value="Instagram">Instagram</option>
                            <option value="Youtube">Youtube</option>
                            <option value="Twitter">Twitter</option>
                            <option value="TikTok">TikTok</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="service">Choose SMM Service:</label>
                    <div class="col-sm-6">
                    <select class="form-control" id="service" name="service">

            
                            <option value ="">Select Service</option>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label" for="quantity">Quantity:</label>
                    <div class="col-sm-6">
                    <input type="number" name="quantity" id="quantity" class="form-control" value="<?php echo $quantity; ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Language:</label>
                    <div class="col-sm-6">
                    <input type="radio" name="lang" id="english" value="English" <?php echo ($lang === 'English') ? 'checked' : ''; ?>>
                        <label for="english">English</label>
                        <input type="radio" name="lang" id="urdu" value="Urdu" <?php echo ($lang === 'Urdu') ? 'checked' : ''; ?>>
                        <label for="urdu">Urdu</label>
                        <input type="radio" name="lang" id="turkish" value="Turkish" <?php echo ($lang === 'Turkish') ? 'checked' : ''; ?>>
                        <label for="turkish">Turkish</label>
                        <input type="radio" name="lang" id="sindhi" value="Sindhi" <?php echo ($lang === 'Sindhi') ? 'checked' : ''; ?>>
                        <label for="sindhi">Sindhi</label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-4 col-form-label">Upload Payment Screenshot:</label>
                    <div class="col-sm-6">
                        <input type="file" name="screenshot" id="upload_file" class="form-control-file" accept="image/jpeg, image/png, image/gif" onchange="previewFile()">
                        <span class="help-block">Allowed File Types: jpg, jpeg, png, gif</span>
                    </div>
                </div>
                <div id="image_preview">
                <?php echo "<th><img src='data:image/jpeg;base64," . base64_encode($row['screenshot']) . "' class='preview-image'></th>" ?>

                </div>
            
                    
                </div>
         

                <?php  
                if(!empty($successMessage)){
                    echo "
                    <div class= 'row mb-3'>
                        <div class='offset-sm-3 col-sm-6'>
                            <div class = 'alert alert-success alert-dismissible fade show' role = 'alert'>
                                <strong>$successMessage</Strong>
                                <button type = 'button' class= 'btn-close' data-bs-dismiss = 'alert' aria-label= 'Close'></button>
                                </div>
                            </div>
                    </div>
                    ";
                }
                ?>
                <div class= "row mb-3">
                    <div class = "offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="/SCS_Task/project1/order_history.php" role="button">Cancel<a>
                    </div>
                </div>
                
                
            </form>
            <br><br>
            
            
        </div>
            <a class="btn btn-primary" href="/SCS_Task/project1/order_history.php" role="button">Go Back</a>
        </div>

<script type="text/javascript">
    
    function myfun(data) {
        var req = new XMLHttpRequest();
        req.open("GET", "/SCS_Task/project1/response.php?datavalue=" + data, true);
        req.send();

        req.onreadystatechange = function () {
            if (req.readyState == 4 && req.status == 200) {
                document.getElementById('service').innerHTML = req.responseText;
            }
        };
}

$(document).ready(function () {
    $("#upload_btn").on("click", function () {
        var formData = new FormData($("#myForm")[0]);

        $.ajax({
            url: "delete.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                $("#image_preview").html(data);
                $("#submit_btn").prop("disabled", false);
                // Clear the file input value
                // $("#upload_file").val("");
            },
        });
    });
});

    </script>
<script>
        function previewFile() {
            const fileInput = document.getElementById('upload_file');
            const preview = document.getElementById('image_preview');

            // Clear previous preview
            preview.innerHTML = '';

            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                const img = document.createElement('img');
                img.classList.add('preview-image');
                img.src = reader.result;
                preview.appendChild(img);
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>