
    <?php
    session_start();
    if (!isset($_SESSION['user'])) 
    {
        header("Location: login.php");
        exit();
    }
    require_once 'class/users.php';
    $mysqli = new mysqli("localhost", "root", "", "fullstack");
    if ($mysqli->connect_errno) {
        die("Koneksi gagal: " . $mysqli->connect_error);
    }

    $password_old = $_POST['old_password'];
    $password_new = $_POST['password'];

    $username = $_SESSION['user']['username'];

    $user = new users();
    
    $success = $user->changePassword($username, $password_old, $password_new);

    if ($success) 
    {
        echo "Password berhasil diubah!<br>";

        if (!empty($_SESSION['user']['npk_dosen'])) 
        {
            echo "<a href='dosen_home.php'>Kembali ke home page?</a>";
        }
        elseif (!empty($_SESSION['user']['nrp_mahasiswa'])) 
        {
            echo "<a href='mahasiswa_home.php'>Kembali ke home page?    </a>";
        } 
        elseif (!empty($_SESSION['user']['isadmin'])) 
        {
            echo "<a href='admin_home.php'>Kembali ke home page?</a>";
        }
    } 
    else 
    {
        echo "Password lama salah atau user tidak ditemukan!<br>";
        echo "<a href='change_password.php'>Kembali ke Change Password?</a><br>";
        if (!empty($_SESSION['user']['npk_dosen'])) 
        {
            echo "<a href='dosen_home.php'>Kembali ke home page?</a>";
        }
        elseif (!empty($_SESSION['user']['nrp_mahasiswa'])) 
        {
            echo "<a href='mahasiswa_home.php'>Kembali ke home page?    </a>";
        } 
        elseif (!empty($_SESSION['user']['isadmin'])) 
        {
            echo "<a href='admin_home.php'>Kembali ke home page?</a>";
        }
    }

    ?>