    <?php
    session_start();
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <style>
            body{
            font-family: 'Times New Roman', Times, serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            }
            h2{
                text-align: center;
                margin-top: 30px;
                color: #333;
                font-size: 36px;
            }
            h4{
                margin-top: 10px;
                color: #555;
                font-size: 20px;
            }
            label{
                font-size: 18px;
                color: #444;
                font-weight: bold;
                margin-top: 15px;
                display: block;
            }
            button{
                font-family: 'Times New Roman', Times, serif;
                padding: 12px;
                width: 100px;
                background-color: #e4f1ffff;
                color: #333;
                font-size: 24px;
                margin-top: 10px;
            }
            input{
                width: 100%;
                padding: 10px;
                margin-top: 5px;
                border: 1px solid #ccc;
            }
            .isiInput{
                background-color: white;
                border:10px solid  #333;
                padding: 30px 40px;
                text-align: center;
                max-width: 400px;
                width: 90%;
            }

            @media (max-width: 600px) {
                .isiInput{
                    width: 90%;      
                    padding: 20px;   
                    border-width: 5px;
                }
                button{
                    width: 100%;   
                    font-size: 20px; 
                }
                h2{
                    font-size: 28px; 
                }
                h4{
                    font-size: 16px;
                }
                label{
                    font-size: 16px;
                }
            }

        </style>
    </head>
    <body> 
        <div class = "isiInput">
        <h2><b>Login</b></h2>
        <h4><b>Masukkan Username dan password anda! </b></h4>
            <form method="POST" action="login_proses.php" enctype="multipart/form-data">
                <label>Username: </label><br>
                <input type = "text" name="txtUsername" required><br>
                <label>Password: </label><br>
                <input type = "password" name="txtPassword" required><br><br>
                <button type="submit" value="simpan" name = "btnSubmit" >Login</button>
            </form>
        </div>
        <script>
            $(document).ready(function() {
                $('#toggleTheme').click(function(){
                    $('body').toggleClass('dark');
                });
            });
        </script>
    </body>
    </html> 