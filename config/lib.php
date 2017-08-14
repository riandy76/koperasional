<?php
// database connection
//require 'config.php';
/**
 * These are the database login details
 */
define("HOST", "localhost");     // The host you want to connect to.
define("USER", "root");    // The database username.
define("PASSWORD", "rtv58");    // The database password.
define("DATABASE", "koperasional");    // The database name.
define('CHARSET', 'utf8');
//fungsi

function DB()
{
static $instance;
if ($instance === null) {
    $opt = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => FALSE,
    );
    $dsn = 'mysql:host=' . HOST . ';dbname=' . DATABASE . ';charset=' . CHARSET;
    $instance = new PDO($dsn, USER, PASSWORD, $opt);
}
return $instance;
}
/**
* Class pengguna
*/
class crudPengguna
{
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

public function searchData($vterm){
try {
        $query = $this->db->prepare("SELECT * FROM pengguna_kas WHERE namaPengguna LIKE :term ORDER BY namaPengguna ASC");
        $term = '%' .$vterm. '%';
        $query->bindParam("term", $term, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;   
} catch (PDOException $e) {
    die("ERROR: Could not able to execute command. " . $e->getMessage());    
}

}

/** method tambah user
variable
            pnama_pengguna: gnama_pengguna,
            palamat_pengguna: galamat_pengguna,
            pnomor_telp: gnomor_telp,
            p_tggl: tggl_tambah,
            pid_user: gid_user
**/
    public function createPengguna($vnama_pengguna, $valamat, $vtelp, $vtggl, $vid_user){
        try {

        $query = $this->db->prepare('INSERT INTO pengguna_kas(namaPengguna, alamatPengguna, nomorTelpon, tgglTambah, id_user_kasir) VALUES(:gnama_pengguna, :galamat_pengguna, :gnomor_telp, :tggl_tambah, :id_user)');
        $query->bindParam("gnama_pengguna", $vnama_pengguna, PDO::PARAM_STR);
        $query->bindParam("galamat_pengguna", $valamat, PDO::PARAM_STR);
        $query->bindParam("gnomor_telp", $vtelp, PDO::PARAM_STR);
        $query->bindParam("tggl_tambah", $vtggl, PDO::PARAM_STR);
        $query->bindParam("id_user", $vid_user, PDO::PARAM_STR);     
        $query->execute();
        return $this->db->lastInsertId();

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

// Read data user
    public function readData(){
        $query = $this->db->prepare("SELECT * FROM pengguna_kas ORDER BY idPengguna ASC");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;        
    }

// details sebelum update
    public function detailsPengguna($vid)
    {
        $query = $this->db->prepare("SELECT * FROM pengguna_kas WHERE idPengguna = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

// update data user
    public function updateData($vid, $vnama_pengguna, $valamat, $vtelp)
    {
        $query = $this->db->prepare("UPDATE pengguna_kas 
         SET namaPengguna =:gnama_pengguna, alamatPengguna =:galamat_pengguna, nomorTelpon =:gnomor_telp 
         WHERE idPengguna = :gid");
        $query->bindParam("gnama_pengguna", $vnama_pengguna, PDO::PARAM_STR);
        $query->bindParam("galamat_pengguna", $valamat, PDO::PARAM_STR);
        $query->bindParam("gnomor_telp", $vtelp, PDO::PARAM_STR);
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }

// delete data user
    public function deleteData($vid)
    {
        $query = $this->db->prepare("DELETE FROM pengguna_kas WHERE idPengguna = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }

}

/**
* Class Master Data tagihan PLN PDAM
*/
class crudMasterTagihan
{
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

// method tambah user
    public function createData($vatas_nama, $vnopel, $vbagian, $vketerangan, $vnama_jenis){
        try {

        $query = $this->db->prepare('INSERT INTO kas_tagihan(no_pelanggan, atas_nama, bagian, keterangan, jenis_biaya) VALUES(:gno_pelanggan, :gatas_nama, :gbagian, :gketerangan, :gjenis_biaya)');
        $query->bindParam("gno_pelanggan", $vnopel, PDO::PARAM_STR);
        $query->bindParam("gatas_nama", $vatas_nama, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjenis_biaya", $vnama_jenis, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

// Read data user
    public function readData(){
        $query = $this->db->prepare("SELECT * FROM kas_tagihan ORDER BY id ASC");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;        
    }

// details sebelum update
    public function details($vid)
    {
        $query = $this->db->prepare("SELECT * FROM jenis_biaya WHERE id_jenis = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

// update data user
    public function updateData($vid_jenis, $vnama_jenis)
    {
        $query = $this->db->prepare("UPDATE jenis_biaya 
         SET nama_jenis =:gnama
         WHERE id_jenis = :gid_jenis");
        $query->bindParam("gnama", $vnama_jenis, PDO::PARAM_STR);
        $query->bindParam("gid_jenis", $vid_jenis, PDO::PARAM_STR);
        $query->execute();
    }

// delete data user
    public function deleteData($vid)
    {
        $query = $this->db->prepare("DELETE FROM jenis_biaya WHERE id_jenis = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }
}

/**
* Class Jenis Biaya
*/
class crudJenisBiaya
{
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

// method tambah user
    public function createJenis($vnama_jenis){
        try {

        $query = $this->db->prepare('INSERT INTO jenis_biaya(nama_jenis) VALUES(:gnama_jenis)');
        $query->bindParam("gnama_jenis", $vnama_jenis, PDO::PARAM_STR);      
        $query->execute();
        return $this->db->lastInsertId();

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

// Read data user
    public function readJenis(){
        $query = $this->db->prepare("SELECT * FROM jenis_biaya ORDER BY id_jenis ASC");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;        
    }

// details sebelum update
    public function detailJenis($vid)
    {
        $query = $this->db->prepare("SELECT * FROM jenis_biaya WHERE id_jenis = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

// update data user
    public function updateJenis($vid_jenis, $vnama_jenis)
    {
        $query = $this->db->prepare("UPDATE jenis_biaya 
         SET nama_jenis =:gnama
         WHERE id_jenis = :gid_jenis");
        $query->bindParam("gnama", $vnama_jenis, PDO::PARAM_STR);
        $query->bindParam("gid_jenis", $vid_jenis, PDO::PARAM_STR);
        $query->execute();
    }

// delete data user
    public function deleteJenis($vid)
    {
        $query = $this->db->prepare("DELETE FROM jenis_biaya WHERE id_jenis = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }
}


/**
* Class AturLogin
*/
class AturLogin
{
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

/* Kumpulan Fungsi Untuk Cek Session Login
     * Register New User
     *
     * @param $name, $email, $username, $password
     * @return ID
     * */
    // public function Register($name, $email, $username, $password)
    // {
    //     try {
    //         $db = DB();
    //         $query = $db->prepare("INSERT INTO users(name, email, username, password) VALUES (:name,:email,:username,:password)");
    //         $query->bindParam("name", $name, PDO::PARAM_STR);
    //         $query->bindParam("email", $email, PDO::PARAM_STR);
    //         $query->bindParam("username", $username, PDO::PARAM_STR);
    //         $enc_password = hash('sha256', $password);
    //         $query->bindParam("password", $enc_password, PDO::PARAM_STR);
    //         $query->execute();
    //         return $db->lastInsertId();
    //     } catch (PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    /*
     * Check Username
     *
     * @param $username
     * @return boolean
     * */
    // public function isUsername($username)
    // {
    //     try {
    //         // $db = DB();
    //         $query = $this->db->prepare("SELECT user_id FROM users WHERE username=:username");
    //         $query->bindParam("username", $username, PDO::PARAM_STR);
    //         $query->execute();
    //         if ($query->rowCount() > 0) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    /*
     * Check Email
     *
     * @param $email
     * @return boolean
     * */
    // public function isEmail($email)
    // {
    //     try {
    //         $db = DB();
    //         $query = $db->prepare("SELECT user_id FROM users WHERE email = :email");
    //         $query->bindParam("email", $email, PDO::PARAM_STR);
    //         $query->execute();
    //         if ($query->rowCount() > 0) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     } catch (PDOException $e) {
    //         exit($e->getMessage());
    //     }
    // }

    /*
     * Login
     *
     * @param $username, $password
     * @return $mixed
     * */
    public function Login($vusername, $vpassword)
    {
        try {
            $query = $this->db->prepare("SELECT idUserKasir FROM user_kasir WHERE user_name =:gusername AND pwd =:gpassword");
            $query->bindParam("gusername", $vusername, PDO::PARAM_STR);
            $enc_password = hash('md5', $vpassword);
            $query->bindParam("gpassword", $enc_password, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
                return $result->idUserKasir;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /*
     * get User Details
     *
     * @param $user_id
     * @return $mixed
     * */
    public function UserDetails($vid)
    {
        try {
            $query = $this->db->prepare("SELECT * FROM user_kasir WHERE idUserKasir =:gid");
            $query->bindParam("gid", $vid, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                return $query->fetch(PDO::FETCH_OBJ);
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function LastLogin($user_id, $time){
        try {
            $query = $this->db->prepare("UPDATE user_kasir 
            SET last_login =:glast_login WHERE idUserKasir =:gid");     
            $query->bindParam("glast_login", $time, PDO::PARAM_STR);
            $query->bindParam("gid", $user_id, PDO::PARAM_STR);
            $query->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}


// Class Atur User
class AturUser
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

// method tambah user
    public function createUser($vidUser, $vnama, $vusername, $vpassword, $vfoto){
        try {

        $query = $this->db->prepare('INSERT INTO user_kasir(idUserKasir, nama, user_name, pwd, pic) VALUES(:giduser, :gnama, :glevel, :gpwd, :gpic)');
        $query->bindParam("giduser", $vidUser, PDO::PARAM_STR);
        $query->bindParam("gnama", $vnama, PDO::PARAM_STR);
        $query->bindParam("glevel", $vusername, PDO::PARAM_STR);
        $query->bindParam("gpwd", $vpassword, PDO::PARAM_STR);
        $query->bindParam("gpic", $vfoto, PDO::PARAM_STR);     
        $query->execute();
        return $this->db->lastInsertId();

        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

// Read data user
    public function readUser(){
        $query = $this->db->prepare("SELECT * FROM user_kasir ORDER BY nama ASC");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;        
    }

// details sebelum update
    public function detailUser($vid)
    {
        $query = $this->db->prepare("SELECT * FROM user_kasir WHERE idUserKasir = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

// update data user
    public function updateUser($vidUser, $vnama, $vusername, $vpassword, $vfoto)
    {
        $query = $this->db->prepare("UPDATE user_kasir 
         SET nama =:gnama, user_name =:gusername, pwd =:gpwd, pic =:gpic
         WHERE idUserKasir = :giduser");
        $query->bindParam("giduser", $vidUser, PDO::PARAM_STR);
        $query->bindParam("gnama", $vnama, PDO::PARAM_STR);
        $query->bindParam("gusername", $vusername, PDO::PARAM_STR);
        $query->bindParam("gpwd", $vpassword, PDO::PARAM_STR);
        $query->bindParam("gpic", $vfoto, PDO::PARAM_STR);
        $query->execute();
    }

// delete data user
    public function deleteUser($vid)
    {
        $query = $this->db->prepare("DELETE FROM user_kasir WHERE idUserKasir = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }

}

// Class atur user

 
class CRUD
{
 
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }
 
    /*
     * Add new Record
     *
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return $mixed
     * */

    public function setStokKas($vkertas_100, $vkertas_50, $vkertas_20, $vkertas_10, $vkertas_5, $vkertas_2,
    $vkertas_1, $vlogam_1000, $vlogam_500, $vlogam_200, $vlogam_100, $vbagian, $vtggl_kas, $vwaktu_tambah, $vketerangan, $vuser_kasir)
    {
        $query = $this->db->prepare('INSERT INTO stok_kas(kertas100, kertas50, kertas20, kertas10, kertas5, kertas2, kertas1, logam1000, logam500, logam200, logam100, bagian, tggl_kas, waktu_tambah, keterangan, user_kasir)VALUES(:gkertas100, :gkertas50, :gkertas20, :gkertas10, :gkertas5, :gkertas2, :gkertas1, :glogam1000, :glogam500, :glogam200, :glogam100, :gbagian, :gtggl_kas, :gwaktu_tambah, :gketerangan, :guser_kasir)');
        $query->bindParam("gkertas100", $vkertas_100, PDO::PARAM_STR);
        $query->bindParam("gkertas50", $vkertas_50, PDO::PARAM_STR);
        $query->bindParam("gkertas20", $vkertas_20, PDO::PARAM_STR);
        $query->bindParam("gkertas10", $vkertas_10, PDO::PARAM_STR);
        $query->bindParam("gkertas5", $vkertas_5, PDO::PARAM_STR);
        $query->bindParam("gkertas2", $vkertas_2, PDO::PARAM_STR);
        $query->bindParam("gkertas1", $vkertas_1, PDO::PARAM_STR);
        $query->bindParam("glogam1000", $vlogam_1000, PDO::PARAM_STR);
        $query->bindParam("glogam500", $vlogam_500, PDO::PARAM_STR);
        $query->bindParam("glogam200", $vlogam_200, PDO::PARAM_STR);
        $query->bindParam("glogam100", $vlogam_100, PDO::PARAM_STR);
                
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);                 
        $query->bindParam("gtggl_kas", $vtggl_kas, PDO::PARAM_STR);
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR); 
        $query->execute();
        return $this->db->lastInsertId();
    }

    public function setSaldoAwal($vsaldo_akhir, $vketerangan, $vtggl_periode, $vwaktu_update, $vbagian, $vuser_kasir, $vstatus_saldo){
        $query = $this->db->prepare('INSERT INTO saldo_kas(saldo_akhir, keterangan, tggl_periode, waktu_update, bagian, id_user_kasir, status_saldo) VALUES(:gsaldo_akhir, :gketerangan, :gtggl_periode, :gwaktu_update, :gbagian, :guser_kasir, :gstatus_saldo)');
        $query->bindParam("gsaldo_akhir", $vsaldo_akhir, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_periode, PDO::PARAM_STR);
        $query->bindParam("gwaktu_update", $vwaktu_update, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);        
        $query->bindParam("gstatus_saldo", $vstatus_saldo, PDO::PARAM_STR);       
        $query->execute();
        return $this->db->lastInsertId();
    }
/**
Update Kas untuk status nya Closing
**/
    public function UpdateClosingKas($vbagian)
    {
    try {
        $query = $this->db->prepare("UPDATE kas_operasional 
        SET status_closing = 1
        WHERE status_closing = 10 AND bagian =:gbagian");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->execute();        
    } catch (PDOException $e) {
        die("ERROR: Could not able to execute command. " . $e->getMessage());
    }

    }  

    public function setBonGantung($vjumlah, $vketerangan, $vpenerima, $vtggl_bon, $vwaktu_bon, $vbagian, $vuser_kasir, $vstatus_bon)
    {
        $query = $this->db->prepare('INSERT INTO bon_gantung(jumlah, keterangan, penerima, tggl_bon, waktu_bon, bagian, user_kasir, status_bon) VALUES(:gjumlah, :gketerangan, :gpenerima, :gtggl_bon, :gwaktu_bon, :gbagian, :guser_kasir, :gstatus_bon)');
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gtggl_bon", $vtggl_bon, PDO::PARAM_STR);
        $query->bindParam("gwaktu_bon", $vwaktu_bon, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);        
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gstatus_bon", $vstatus_bon, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
//set uang muka, digunakan file uang muka create
    public function setUangMuka($vno_bukti_kas, $vpenerima, $vjumlah, $vketerangan, $vjenis_biaya, $vbagian, $vtggl_kas, $vwaktu_tambah, $vuser_kasir, $vstatus_kas, $status_closing)
    {
        $query = $this->db->prepare('INSERT INTO kas_operasional(no_bukti_kas, penerima, jumlah, keterangan, jenis_biaya, bagian, tggl_kas, waktu_tambah, user_kasir, status_kas, status_closing, jenis_kas) VALUES(:gno_bukti_kas, :gpenerima, :gjumlah, :gketerangan, :gjenis_biaya, :gbagian, :gtggl_kas, :gwaktu_tambah, :guser_kasir, :gstatus_kas, :gstatus_closing, "kas_keluar")');
        $query->bindParam("gno_bukti_kas", $vno_bukti_kas, PDO::PARAM_STR);
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjenis_biaya", $vjenis_biaya, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vtggl_kas, PDO::PARAM_STR);
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gstatus_kas", $vstatus_kas, PDO::PARAM_STR);
        $query->bindParam("gstatus_closing", $status_closing, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
    
public function createDosen($vnama_dosen)
    {
        $query = $this->db->prepare('INSERT INTO data_dosen(nama_dosen) VALUES(:gnama_dosen)');
        $query->bindParam("gnama_dosen", $vnama_dosen, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    }
//digunakan oleh file uang_muka_realisasi.php
    public function setKasMasuk($vno_bukti_kas, $vpenerima, $vjumlah, $vketerangan, $vjenis_biaya, $vbagian, $vtggl_kas, $vwaktu_tambah, $vuser_kasir, $vstatus_saldo, $vstatus_closing)
    {
try {

    $query = $this->db->prepare("INSERT INTO kas_operasional(no_bukti_kas, penerima, jumlah, keterangan, jenis_biaya, bagian, tggl_kas, waktu_tambah, user_kasir, status_kas, status_closing, jenis_kas) VALUES (:gno_bukti_kas,:gpenerima,:gjumlah,:gketerangan,:gjenis_biaya,:gbagian,:gtggl_kas,:gwaktu_tambah,:guser_kasir, :gstatus_kas, :gstatus_closing, 'kas_masuk')");
        $query->bindParam("gno_bukti_kas", $vno_bukti_kas, PDO::PARAM_STR);
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjenis_biaya", $vjenis_biaya, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vtggl_kas, PDO::PARAM_STR);
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gstatus_kas", $vstatus_saldo, PDO::PARAM_STR);
        $query->bindParam("gstatus_closing", $vstatus_closing, PDO::PARAM_STR);
        $query->execute();
        return $this->db->lastInsertId();
    
} catch (PDOException $e) {
    exit($e->getMessage());    
}

}

/*
    * Read Record
    *
    * @param $first_name
    * @param $last_name
    * @param $email
    * @return $mixed
* */

/**
Ambil data Debet Kredit dari tanggal terpilih.
digunakan oleh file :
do_stok_kas_get_saldo_KO.php
kas_operasional_get.php
**/
    public function getDebetKredit($vbagian, $vtggl_kas){
        $query = $this->db->prepare("SELECT
            (SELECT COALESCE(SUM(jumlah),0)
            FROM kas_operasional WHERE jenis_kas = 'kas_masuk' AND bagian =:gbagian_km AND tggl_kas =:gtggl_kas_km) AS totalDebet,
            (SELECT COALESCE(SUM(jumlah),0)
            FROM kas_operasional WHERE jenis_kas = 'kas_keluar' AND  bagian =:gbagian_kl AND tggl_kas =:gtggl_kas_kl) AS totalKredit");
        $query->bindParam("gbagian_km", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas_km", $vtggl_kas, PDO::PARAM_STR);
        $query->bindParam("gbagian_kl", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas_kl", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;        
    }

/**
Fungsi untuk melihat data dari tabel saldo_kas dengan status_saldo = 0 (bearti saldo awal periode),
 jika status_saldo = 1 bearti saldo dari proses closing.
**/
    // public function getSaldoPusat(){
    //     $query = $this->db->prepare("SELECT * FROM saldo_kas 
    //         WHERE bagian = 'PUSAT' AND status_saldo = 0
    //         ORDER BY waktu_update DESC LIMIT 1");
    //     $query->execute();
    //     $data = array();
    //     while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    //         $data[] = $row;
    //     }
    //     return $data;        
    // }

    // public function getSaldoCabang(){
    //     $query = $this->db->prepare("SELECT * FROM saldo_kas
    //         WHERE bagian = 'CABANG' AND status_saldo = 0
    //         ORDER BY waktu_update DESC LIMIT 1");
    //     $query->execute();
    //     $data = array();
    //     while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    //         $data[] = $row;
    //     }
    //     return $data;        
    // }

/**
Fungsi untuk cek saldo kas 
apakah sudah ada data saldo awal periode nya.
cari data dengan status saldo awal periode / 
**/
    public function getSaldoKasAwalPeriode($vbagian)
    {   
        $query = $this->db->prepare("SELECT
        bagian,
        saldo_akhir,
        keterangan,
        tggl_periode,
        nama
        FROM saldo_kas t1
            INNER JOIN
            user_kasir t2 ON t1.id_user_kasir = t2.idUserKasir
            WHERE t1.bagian =:gbagian AND t1.status_saldo = 2
            ORDER BY t1.waktu_update DESC LIMIT 1");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

/**
Fungsi untuk lihat data laporan stok kas harian
di hari terpilih di tabel stok_kas
digunakan oleh file do_stok_kas_read.php
**/
    public function getStokKas($vbagian, $vtggl_kas)
    {   
        $query = $this->db->prepare("SELECT * FROM stok_kas
        WHERE bagian =:gbagian AND tggl_kas =:gtggl_periode
        LIMIT 1");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

/**
Fungsi untuk cek data dari tabel saldo_kas
di hari terpilih.
dengan status_saldo = 1 (status nya closing)
digunakan oleh file :
include/readSaldoKas.php (untuk cek di halaman Uang Muka)
include/do_stok_kas_get_saldo_KO.php
**/
    public function getSaldoKas($vbagian, $vtggl_periode)
    {   
        $query = $this->db->prepare("SELECT * FROM saldo_kas
        WHERE bagian =:gbagian AND tggl_periode =:gtggl_periode
        AND status_saldo = 1 LIMIT 1");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_periode, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

//status_saldo 1 = status closing. dipakai oleh file kas_operasional_get.php, do_saldo_kas_closing_read.php
    public function getSaldoKasClosing($vbagian, $vtggl_periode)
    {   
        $query = $this->db->prepare("SELECT * FROM saldo_kas
        WHERE bagian =:gbagian AND tggl_periode =:gtggl_periode
        AND status_saldo = 1 LIMIT 1");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_periode, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

    public function getKasKeluar_belumClosing($vbagian, $vtggl_kas)
    {   
        $query = $this->db->prepare("SELECT SUM(jumlah) jumlah FROM kas_operasional
            WHERE
            jenis_kas = 'kas_keluar' AND bagian =:gbagian AND status_closing = 10 AND tggl_kas <:gtggl_periode");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

    public function getKasMasuk_belumClosing($vbagian, $vtggl_kas)
    {   
        $query = $this->db->prepare("SELECT SUM(jumlah) jumlah FROM kas_operasional
            WHERE 
            jenis_kas = 'kas_masuk' AND bagian =:gbagian AND status_closing = 10 AND tggl_kas <:gtggl_periode");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

/**
Fungsi getSaldoKasClosing() digunakan untuk cek saldo kas yang di closing pada hari ini
apakah sudah ada,
jika ada, maka disable button Closing.
digunakan oleh file 
master/saldo_kas_closing_sebelum_read.php
include/do_saldo_kas_closing_read.php
include/do_saldo_kas_last_closing_read.php
include/kas_operasional_get.php
status_saldo = 1 (closing).
**/
    public function getLastClosing($vbagian, $vtggl_kas)
    {   
        $query = $this->db->prepare("SELECT * FROM saldo_kas
        WHERE bagian =:gbagian AND status_saldo = 1 AND tggl_periode <:gtggl_periode
        ORDER BY waktu_update DESC LIMIT 1");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_periode", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }


/**
digunakan oleh file kas_operasional_get.php                
**/
    public function getKasKeluar($vbagian, $vfrom_date)
    {   
        $query = $this->db->prepare("SELECT
        no_bukti_kas, namaPengguna, keterangan, jumlah 
        FROM kas_operasional t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna 
        WHERE t1.jenis_kas = 'kas_keluar' AND t1.tggl_kas =:gtggl_kas AND t1.bagian =:gbagian 
        ORDER BY t1.waktu_tambah DESC");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vfrom_date, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
/**
FROM saldo_kas t1
            INNER JOIN
            user_kasir t2 ON t1.id_user_kasir = t2.idUserKasir
            WHERE t1.bagian =:gbagian AND t1.status_saldo = 2
            ORDER BY t1.waktu_update DESC LIMIT 1
**/
    public function getKasMasuk($vbagian, $vfrom_date)
    {   
        $query = $this->db->prepare("SELECT
        id,
        tggl_kas,
        no_bukti_kas,
        keterangan,
        jumlah,
        namaPengguna
        FROM kas_operasional t1 INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna
            WHERE t1.jenis_kas = 'kas_masuk' AND t1.tggl_kas =:gtggl_kas AND t1.bagian =:gbagian
            ORDER BY t1.waktu_tambah DESC");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vfrom_date, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

/**
Fungsi untuk melihat data kas yang masih berstatus uang muka per tanggal
digunakan oleh file uang_muka_print.php
**/
    public function getUangMuka($vbagian, $vfrom_date, $vstatus_kas)
    {   
      $query = $this->db->prepare("SELECT
      id, no_bukti_kas, namaPengguna, keterangan, jumlah, tggl_kas
      FROM kas_operasional t1
      INNER JOIN pengguna_kas t2
      ON t1.penerima = t2.idPengguna
      WHERE t1.jenis_kas = 'kas_keluar' AND t1.tggl_kas <=:gtggl_kas AND t1.bagian =:gbagian AND t1.status_kas =:gstatus_kas
      ORDER BY t1.waktu_tambah DESC");
      $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
      $query->bindParam("gtggl_kas", $vfrom_date, PDO::PARAM_STR);
      $query->bindParam("gstatus_kas", $vstatus_kas, PDO::PARAM_STR);
      $query->execute();
      $data = array();
      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
      }
      return $data;
    }
    public function getDosen()
    {   
        $query = $this->db->prepare("SELECT * FROM data_dosen
            ORDER BY nama_dosen ASC");
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
/**
**/
    public function getBiaya($vbagian, $vfrom_date, $vstatus_kas)
    {   
        $query = $this->db->prepare("SELECT
        id, tggl_kas, no_bukti_kas, namaPengguna, keterangan, jumlah, status_kas
        FROM kas_operasional t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna 
            WHERE
t1.jenis_kas = 'kas_keluar' AND t1.tggl_kas =:gtggl_kas AND t1.bagian =:gbagian AND t1.status_kas =:gstatus_kas
            ORDER BY t1.waktu_tambah DESC");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vfrom_date, PDO::PARAM_STR);
        $query->bindParam("gstatus_kas", $vstatus_kas, PDO::PARAM_STR);
        $query->execute();
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
/**
status_bon = 9, bearti status nya masih bon / belum di bayar
**/
    public function getBonGantung($vbagian, $vtggl_bon)
    {   
        $query = $this->db->prepare("SELECT * FROM bon_gantung
        WHERE bagian =:gbagian AND status_bon = 9 AND tggl_bon <=:gtggl_bon
        ORDER BY waktu_bon DESC");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_bon", $vtggl_bon, PDO::PARAM_STR);
        $query->execute();       
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
// dipakai oleh file do_bon_gantung_read.php
/****/
    public function getBon($vbagian, $vtggl_bon)
    {
    try {
        $query = $this->db->prepare("SELECT
        id, tggl_bon, bagian, namaPengguna, keterangan, jumlah, tggl_bayar, status_bon
        FROM bon_gantung t1
            INNER JOIN pengguna_kas t2
            ON t1.penerima = t2.idPengguna
        WHERE bagian =:gbagian AND tggl_bon <=:gtggl_bon
        ORDER BY waktu_bon DESC");
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->bindParam("gtggl_bon", $vtggl_bon, PDO::PARAM_STR);
        $query->execute();       
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;           
       } catch (PDOException $e) {
       exit($e->getMessage());    
       }   
    }
     
    /*
     * Delete Record
     *
     * @param $user_id
     * */
    public function DeleteKasKeluar($vid)
    {
        $query = $this->db->prepare("DELETE FROM kas_operasional WHERE id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }
    public function DeleteDosen($vnama_dosen)
    {
        $query = $this->db->prepare("DELETE FROM data_dosen WHERE nama_dosen = :gnama_dosen");
        $query->bindParam("gnama_dosen", $vnama_dosen, PDO::PARAM_STR);
        $query->execute();
    }
    public function DeleteKasMasuk($vid)
    {
    $query = $this->db->prepare("DELETE FROM kas_operasional
        WHERE
        jenis_kas = 'kas_masuk' AND id = :gid");
    $query->bindParam("gid", $vid, PDO::PARAM_STR);
    $query->execute();
    }

    public function DeleteBonGantung($vid)
    {
        $query = $this->db->prepare("DELETE FROM bon_gantung WHERE id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Update Record
     *
     * @param $first_name
     * @param $last_name
     * @param $email
     * @return $mixed
     * 
    */
    public function updateStokKas($vkertas_100, $vkertas_50, $vkertas_20, $vkertas_10, $vkertas_5, $vkertas_2,
    $vkertas_1, $vlogam_1000, $vlogam_500, $vlogam_200, $vlogam_100, $vbagian, $vtggl_kas, $vwaktu_update, $vketerangan, $vuser_kasir){
        $query = $this->db->prepare("UPDATE stok_kas 
        SET bagian =:gbagian, kertas100 =:gkertas100, kertas50 =:gkertas50, kertas20 =:gkertas20,
        kertas10 =:gkertas10, kertas5 =:gkertas5, kertas2 =:gkertas2, kertas1 =:gkertas1, logam1000 =:glogam1000,
        logam500 =:glogam500, logam200 =:glogam200, logam100 =:glogam100, keterangan =:gketerangan,
        waktu_tambah =:gwaktu_tambah, user_kasir =:guser_kasir
        WHERE tggl_kas =:gtggl_kas");
        
        $query->bindParam("gkertas100", $vkertas_100, PDO::PARAM_STR);
        $query->bindParam("gkertas50", $vkertas_50, PDO::PARAM_STR);
        $query->bindParam("gkertas20", $vkertas_20, PDO::PARAM_STR);
        $query->bindParam("gkertas10", $vkertas_10, PDO::PARAM_STR);
        $query->bindParam("gkertas5", $vkertas_5, PDO::PARAM_STR);
        $query->bindParam("gkertas2", $vkertas_2, PDO::PARAM_STR);
        $query->bindParam("gkertas1", $vkertas_1, PDO::PARAM_STR);
        $query->bindParam("glogam1000", $vlogam_1000, PDO::PARAM_STR);
        $query->bindParam("glogam500", $vlogam_500, PDO::PARAM_STR);
        $query->bindParam("glogam200", $vlogam_200, PDO::PARAM_STR);
        $query->bindParam("glogam100", $vlogam_100, PDO::PARAM_STR);
        
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);        
        $query->bindParam("gwaktu_tambah", $vwaktu_update, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();
    }
/**
status_bon = 1 (sudah bayar)
waktu_bon, penerima, keterangan, jumlah,
user_kasir
**/
    public function UpdateBonBayar($vid, $vtggl_bayar)
    {
        $query = $this->db->prepare("UPDATE bon_gantung 
         SET status_bon = 1, tggl_bayar =:gtggl_bayar
         WHERE id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->bindParam("gtggl_bayar", $vtggl_bayar, PDO::PARAM_STR);
        $query->execute();
    }

    public function UpdateBonGantung($vid, $vwaktu_bon, $vpenerima, $vketerangan, $vjumlah, $vuser_kasir)
    {
        $query = $this->db->prepare("UPDATE bon_gantung 
         SET waktu_bon =:gwaktu_bon, penerima =:gpenerima, keterangan =:gketerangan,
             jumlah =:gjumlah, user_kasir =:guser_kasir
         WHERE id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->bindParam("gwaktu_bon", $vwaktu_bon, PDO::PARAM_STR);
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->execute();
    }

    public function UpdateUangMuka($vid, $vpenerima, $vjumlah, $vjenis_biaya, $vketerangan, $vwaktu_tambah, $vuser_kasir, $vstatus_kas)
    {
        $query = $this->db->prepare("UPDATE kas_operasional 
        SET penerima =:gpenerima, jumlah =:gjumlah, keterangan =:gketerangan, jenis_biaya =:gjenis_biaya, waktu_tambah =:gwaktu_tambah, user_kasir =:guser_kasir, status_kas =:gstatus_kas
            WHERE id =:gid");
        
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjenis_biaya", $vjenis_biaya, PDO::PARAM_STR);        
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gstatus_kas", $vstatus_kas, PDO::PARAM_STR);
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }

/**
Fungsi update status Uang Muka menjadi Realisasi dengan Update data table kas_keluar,
kolom status_kas menjadi 5 (realisasi)
**/
    public function UpdateUangMukaRealisasi($vid, $vwaktu_tambah, $vuser_kasir)
    {
        $query = $this->db->prepare("UPDATE kas_operasional 
            SET waktu_tambah =:gwaktu_tambah, user_kasir =:guser_kasir, status_kas = 5 WHERE id =:gid");     
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }


    public function UpdateKasMasuk($vid, $vpenerima, $vjumlah, $vjenis_biaya, $vketerangan, $vwaktu_tambah, $vuser_kasir)
      {
$query = $this->db->prepare("UPDATE kas_operasional
    SET penerima =:gpenerima, jumlah =:gjumlah, keterangan =:gketerangan, jenis_biaya =:gjenis_biaya, waktu_tambah =:gwaktu_tambah, user_kasir =:guser_kasir
    WHERE 
    jenis_kas = 'kas_masuk' AND id =:gid");
        
        $query->bindParam("gpenerima", $vpenerima, PDO::PARAM_STR);
        $query->bindParam("gjumlah", $vjumlah, PDO::PARAM_STR);
        $query->bindParam("gketerangan", $vketerangan, PDO::PARAM_STR);
        $query->bindParam("gjenis_biaya", $vjenis_biaya, PDO::PARAM_STR);        
        $query->bindParam("gwaktu_tambah", $vwaktu_tambah, PDO::PARAM_STR);
        $query->bindParam("guser_kasir", $vuser_kasir, PDO::PARAM_STR);
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
    }
 
    /*
     * Get Details
     * */
    public function DetailsKasKeluar($vid)
    {
        $query = $this->db->prepare("SELECT
        id, tggl_kas, no_bukti_kas, penerima, namaPengguna, keterangan, jumlah, jenis_biaya
        FROM kas_operasional t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna
        WHERE t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
/**
digunakan oleh file kas_masuk_details.php
**/
    public function DetailsKasMasuk($vid)
    {
        $query = $this->db->prepare("SELECT
        no_bukti_kas, namaPengguna, jumlah, jenis_biaya, keterangan
        FROM kas_operasional t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna
        WHERE t1.jenis_kas = 'kas_masuk' AND t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }

/**
Get Details Stok Kas per Tanggal
**/
    public function DetailsStokKas($vid)
    {
        $query = $this->db->prepare("SELECT * FROM stok_kas WHERE id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
/**
SELECT
        id, tggl_bon, tggl_bayar, waktu_bon, namaPengguna, keterangan, jumlah, bagian
        FROM bon_gantung t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna WHERE t1.id = :gid

            $("#vtggl_bon_update").val(kas.tggl_bon);
            $("#vpenerima_update").val(kas.penerima);
            $("#vjumlah_update").val(kas.jumlah);
            $("#vbagian_update").val(kas.bagian);
            $("#vketerangan_update").val(kas.keterangan);
**/
    public function DetailsBonGantung($vid)
    {
        $query = $this->db->prepare("SELECT
        id, tggl_bon, tggl_bayar, waktu_bon, namaPengguna, keterangan, jumlah, bagian
        FROM bon_gantung t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna
        WHERE t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();       
        return json_encode($query->fetch(PDO::FETCH_ASSOC));
    }
/**
Fungsi untuk ambil data saat print kwitansi atau laporan
**/
    public function LaporanKasHarianPrint($tgLaporan, $vbagian)
    {
        $query = $this->db->prepare("SELECT tggl_kas, Kantor, Bonus, Gaji_Lembur, Dinas, BBM, PLN, PDAM, Internet, Telpon, Entertain, BudgetOperasional, Hutang, Dropping,
 Kantor + Bonus + Gaji_Lembur + Dinas + BBM + PLN + PDAM + Internet + Telpon + Entertain + BudgetOperasional + Hutang AS Jumlah 
FROM (SELECT
    tggl_kas, 
    SUM(IF(jenis_biaya = 1 AND status_kas = 4, jumlah, 0)) AS Kantor,
    SUM(IF(jenis_biaya = 2 AND status_kas = 4, jumlah, 0)) AS Bonus,
    SUM(IF(jenis_biaya = 3 AND status_kas = 4, jumlah, 0)) AS Gaji_Lembur,
    SUM(IF(jenis_biaya = 4 AND status_kas = 4, jumlah, 0)) AS Dinas,
    SUM(IF(jenis_biaya = 5 AND status_kas = 4, jumlah, 0)) AS BBM,
    SUM(IF(jenis_biaya = 6 AND status_kas = 4, jumlah, 0)) AS PLN,
    SUM(IF(jenis_biaya = 7 AND status_kas = 4, jumlah, 0)) AS PDAM,
    SUM(IF(jenis_biaya = 8 AND status_kas = 4, jumlah, 0)) AS Internet,
    SUM(IF(jenis_biaya = 9 AND status_kas = 4, jumlah, 0)) AS Telpon,
    SUM(IF(jenis_biaya = 10 AND status_kas = 4, jumlah, 0)) AS Entertain,
    SUM(IF(jenis_biaya = 12 AND status_kas = 4, jumlah, 0)) AS BudgetOperasional,
    SUM(IF(jenis_biaya = 11 AND status_kas = 4, jumlah, 0)) AS Hutang,
    SUM(IF(jenis_biaya = 15 AND status_kas = 12, jumlah, 0)) AS Dropping
    FROM kas_operasional
    WHERE (jenis_kas = 'kas_keluar' OR jenis_kas = 'kas_masuk') AND YEAR(tggl_kas) = YEAR(:gtggl_kas_y)
    AND MONTH(tggl_kas) = MONTH(:gtggl_kas_m) AND bagian =:gbagian
    GROUP BY tggl_kas) a");
        $query->bindParam("gtggl_kas_y", $tgLaporan, PDO::PARAM_STR);
        $query->bindParam("gtggl_kas_m", $tgLaporan, PDO::PARAM_STR);
        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->execute();
        
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
/**
        $vtggl_bon = $d['tggl_bon'];
        $vtggl_bayar = $d['tggl_bayar'];
        $vwaktu_bon = $d['waktu_bon'];
        $vpenerima = $d['penerima'];
        $vketerangan = $d['keterangan'];
        $vjumlah = $d['jumlah'];
        $vuser_kasir = $d['user_kasir'];
        $vbagian = $d['bagian'];
**/
    public function DetailsBonGantungPrint($vid)
    {
        $query = $this->db->prepare("SELECT
        id, tggl_bon, tggl_bayar, waktu_bon, namaPengguna, keterangan, jumlah, bagian
        FROM bon_gantung t1
        INNER JOIN pengguna_kas t2
        ON t1.penerima = t2.idPengguna WHERE t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
        
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
/**
digunakan oleh file uang_muka_print_bukti_kas.php
**/
    public function DetailsKasKeluarPrint($vid)
    {
        $query = $this->db->prepare("SELECT
            id, tggl_kas, no_bukti_kas, namaPengguna, keterangan, jumlah
            FROM kas_operasional t1
            INNER JOIN pengguna_kas t2
            ON t1.penerima = t2.idPengguna
            WHERE t1.jenis_kas = 'kas_keluar' AND t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
        
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function DetailsKasMasukPrint($vid)
    {
        $query = $this->db->prepare("SELECT
            id, tggl_kas, no_bukti_kas, namaPengguna, keterangan, jumlah
            FROM kas_operasional t1
            INNER JOIN pengguna_kas t2
            ON t1.penerima = t2.idPengguna 
            WHERE t1.jenis_kas = 'kas_masuk' AND t1.id = :gid");
        $query->bindParam("gid", $vid, PDO::PARAM_STR);
        $query->execute();
        
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function StokKasPrint($vtggl_kas)
    {
        $query = $this->db->prepare("SELECT * FROM stok_kas WHERE tggl_kas = :gtggl_kas
            ORDER BY waktu_tambah DESC LIMIT 1");
        $query->bindParam("gtggl_kas", $vtggl_kas, PDO::PARAM_STR);
        $query->execute();
        
        $data = array();
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

}

/**
* Nomor Otomatis
*/
class NomorKas
{
    protected $db;
 
    function __construct()
    {
        $this->db = DB();
    }
 
    function __destruct()
    {
        $this->db = null;
    }

/**
Fungsi Nomor Otomatis
**/
    public function no_kas_keluar($vbagian)
    {
        $array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $bulan = $array_bulan[date('n')];
        $tahun = date("Y");

        $query = $this->db->prepare("SELECT count(*) FROM kas_operasional 
             WHERE jenis_kas = 'kas_keluar' AND bagian = :gbagian AND MONTH(tggl_kas) = MONTH(CURRENT_DATE())");

        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);
        $query->execute(); 
        $number_of_rows = $query->fetchColumn();
        $next_row = $number_of_rows + 1;
        if ($vbagian == 'PUSAT'){

            $vkodebagian = '/KKPST/';
        }else{

            $vkodebagian = '/KKBJM/';
        }
        $kode = str_pad($next_row, 3, "0", STR_PAD_LEFT).$vkodebagian.$bulan.'-'.$tahun.'';

        return $kode;
    }

    public function no_kas_masuk($vbagian)
    {
        $array_bulan = array(1=>"I","II","III", "IV", "V","VI","VII","VIII","IX","X", "XI","XII");
        $bulan = $array_bulan[date('n')];
        $tahun = date("Y");

        $query = $this->db->prepare("SELECT count(*) FROM kas_operasional 
           WHERE 
           jenis_kas = 'kas_masuk' AND bagian = :gbagian AND MONTH(tggl_kas) = MONTH(CURRENT_DATE())");

        $query->bindParam("gbagian", $vbagian, PDO::PARAM_STR);         
        $query->execute(); 
        $number_of_rows = $query->fetchColumn();
        $next_row = $number_of_rows + 1;
        if ($vbagian == 'PUSAT'){

            $vkodebagian = '/KMPST/';
        }else{

            $vkodebagian = '/KMBJM/';
        }
        $kode = str_pad($next_row, 3, "0", STR_PAD_LEFT).$vkodebagian.$bulan.'-'.$tahun.'';

        return $kode;
    }
    
}
 
?>