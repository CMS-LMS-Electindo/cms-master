<?php
header('Content-Type: application/json');
// $request = $_SERVER['REQUEST_URI'];
$request=strtok($_SERVER["REQUEST_URI"],'?');
switch ($request) {
    case '/' :
        index();
        // require __DIR__ . '/views/index.php';
        break;
    case '/cms-all-fakultas' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->categoryFakultas($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-all-prodi' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->categoryProdi($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-all-dosen' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataAllDosen($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-all-mahasiswa' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataAllMahasiswa($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-dosen-mk-semester' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataDosenMKSemester($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-dosen-per-mk-semester' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataDosenPerMKSemester($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-mahasiswa-per-mk-semester' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataMahasiswaPerMKSemester($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    
    case '/cms-login' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->login($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;    
    
    case '/cms-mahasiswa-mk-semester' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataMahasiswaMKSemester($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;
    case '/cms-detail-mk' :
        $testObject = new Apisia();
        if (isset($_GET['h']) &&  isset($_GET['app']))
            $data = $testObject->dataDetailMK($_GET['h'], $_GET['app']);
        else
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        echo json_encode($data);
        break;    
    default:
        break;
}

function index()
{
    echo "teettetet";
}
class Apisia{
	var $host = "localhost";
	var $username = "root";
	var $password = "";
	var $database = "umpar";
	var $koneksi = "";
    var $token = "cms-apisia-4b72926408f7ggfa93946";
    var $appName = "cms-lms";
	function __construct(){
		$this->koneksi = mysqli_connect($this->host, $this->username, $this->password,$this->database);
		if (mysqli_connect_errno()){
			echo "Koneksi database gagal : " . mysqli_connect_error();
			die;
		}
	}
 
    public function categoryFakultas($header, $app)
    {
        // $qMhs = $this->sia->query("SELECT C_KODE_FAKULTAS as kode_fakultas, NAMA_FAKULTAS as nama_fakultas, C_KODE_PT as kode_pt FROM t_mst_fakultas WHERE C_KODE_FAKULTAS<>90 ");
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT KdUnit as kode_fakultas, NamaUnit as nama_fakultas, '091024' as kode_pt FROM unit WHERE (KdUnit <> '09' AND KdUnit <> '10' AND KdUnit <> '11');");
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['nama_fakultas'] = $row['nama_fakultas'];
                    $nestedData['kode_pt'] = $row['kode_pt'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data fakultas ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status"          => 0,
                    "message"          => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function categoryProdi($header, $app)
    {
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT KdProdi as kode_prodi, Prodi as nama_prodi, KdUnit as kode_fakultas FROM prodi WHERE (KdUnit <> '09' AND KdUnit <> '10' AND KdUnit <> '11');");
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['kode_prodi'] = $row['kode_fakultas'] . $row['kode_prodi'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data program studi ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status"          => 0,
                    "message"          => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function dataAllDosen($header, $app)
    {
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT a.KdDosen as kode_dosen, a.Nama as nama_dosen,
            b.KdProdi as kode_prodi, 
            c.Prodi as nama_prodi, 
            c.KdUnit as kode_fakultas, 
            d.NamaUnit as nama_fakultas,
            '-' as email 
            FROM dosen a
            LEFT JOIN prodiajardosen b ON a.KdDosen=b.KdDosen
            LEFT JOIN prodi c ON c.KdProdi=b.KdProdi
            LEFT JOIN unit d ON c.KdUnit=d.KdUnit WHERE a.KdDosen <> 'D-000' GROUP BY a.KdDosen;");
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    // $nestedData['kode_dosen'] = strtolower($row['kode_dosen']);
                    $nestedData['kode_dosen'] = $row['kode_dosen'];
                    $nestedData['nama_dosen'] = $row['nama_dosen'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['nama_fakultas'] = $row['nama_fakultas'];
                    $nestedData['email'] = $row['email'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Dosen ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status"          => 0,
                    "message"          => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status"          => 0,
                "message"          => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function dataAllMahasiswa($header, $app)
    {
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT '091024' as kode_pt, KdFak as kode_fakultas, b.NamaUnit as nama_fakultas,  a.KdProdi as kode_prodi, c.Prodi as nama_prodi, NIM as kode_mahasiswa, Nama as nama_mahasiswa, '' as email FROM mahasiswa a 
            INNER JOIN unit b ON b.KdUnit=a.KdFak
            INNER JOIN prodi c ON c.KdProdi=a.KdProdi
            WHERE (a.NIM <> 1 AND a.NIM <> 0)
            GROUP BY nim; ");
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_pt'] = $row['kode_pt'];
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['nama_fakultas'] = $row['nama_fakultas'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['kode_mahasiswa'] = $row['kode_mahasiswa'];
                    $nestedData['nama_mahasiswa'] = $row['nama_mahasiswa'];
                    $nestedData['email'] = $row['email'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Dosen ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function dataDosenMKSemester($header, $app)
    {
        $tahun_akademik = $_POST['tahun_akademik'];
        $sem = $_POST['semester'];
        // $nidn = $_POST['nidn']; //Opsional
        // $tipe = $_POST['tipe']; 
        // $kode_prodi = $_POST['kode_prodi']; 
        // $search = $_POST['search']; 
        $group = "";
        if (isset($_POST['tipe']) ){
            if ($_POST['tipe'] == 1)
                $group = " GROUP BY a.KdMK, a.KdDosen";
        }
        if ($sem == "1")
            $semester = "Gasal";
        else
            $semester = "Genap";

        $tWhere = "";
        if (isset($_POST['kode_prodi']))
            $tWhere .= " AND b.KdProdi ='".$_POST['kode_prodi']."'";
        if (isset($_POST['search']))
            $tWhere .= " AND b.Matakuliah LIKE '%".$_POST['search']."%'";

        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {

            if (isset($_POST['nidn'])){
                $cek=mysqli_query($this->koneksi,"SELECT b.KdProdi as kode_prodi, c.Prodi as nama_prodi, a.KdKonsentrasi as kode_kurikulum, a.KdMK as kode_mk, b.Matakuliah as nama_mk, a.Kelas as kode_kelas, a.KdDosen as nidn
                FROM makuldosen a
                INNER JOIN matakuliah b ON b.KdMK = a.KdMK AND a.KdKonsentrasi = b.KdKonsentrasi
                INNER JOIN prodi c ON b.KdProdi= c.KdProdi
                WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' AND a.KdDosen='".$_POST['nidn']."' ".$tWhere. $group);
            }else{
                $cek=mysqli_query($this->koneksi,"SELECT b.KdProdi as kode_prodi, c.Prodi as nama_prodi, a.KdKonsentrasi as kode_kurikulum, a.KdMK as kode_mk, b.Matakuliah as nama_mk, a.Kelas as kode_kelas, a.KdDosen as nidn
                FROM makuldosen a
                INNER JOIN matakuliah b ON b.KdMK = a.KdMK AND a.KdKonsentrasi = b.KdKonsentrasi
                INNER JOIN prodi c ON b.KdProdi= c.KdProdi
                WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere. $group);
            }
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['nidn'] = $row['nidn'];
                    $nestedData['kode_kurikulum'] = $row['kode_kurikulum'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['kode_mk'] = $row['kode_mk'];
                    $nestedData['nama_mk'] = $row['nama_mk'];
                    $nestedData['kode_kelas'] = $row['kode_kelas'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Mata Kuliah ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function dataDosenPerMKSemester($header, $app)
    {
        $tahun_akademik = $_POST['tahun_akademik'];
        $sem = $_POST['semester'];
        // $nidn = $_POST['nidn']; //Opsional
        // $tipe = $_POST['tipe']; 
        // $kode_prodi = $_POST['kode_prodi']; 
        // $search = $_POST['search']; 

        $group = " GROUP BY  a.KdDosen";
        if ($sem == "1")
            $semester = "Gasal";
        else
            $semester = "Genap";

        $tWhere = "";
        if (isset($_POST['kode_mk']))
            $tWhere .= " AND b.KdMK ='".$_POST['kode_mk']."'";
        if (isset($_POST['kode_kurikulum']))
            $tWhere .= " AND a.KdKonsentrasi ='".$_POST['kode_kurikulum']."'";

        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            
            $cek=mysqli_query($this->koneksi,"SELECT a.KdDosen as kode_dosen, d.Nama as nama_dosen, b.KdProdi as kode_prodi, c.Prodi as nama_prodi, c.KdUnit as kode_fakultas, '' as email , a.KdKonsentrasi
            FROM makuldosen a
            INNER JOIN matakuliah b ON b.KdMK = a.KdMK AND a.KdKonsentrasi = b.KdKonsentrasi
            INNER JOIN prodi c ON b.KdProdi= c.KdProdi
            INNER JOIN dosen d ON d.KdDosen = a.KdDosen
            WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere. $group);

            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_dosen'] = $row['kode_dosen'];
                    $nestedData['nama_dosen'] = $row['nama_dosen'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['email'] = $row['email'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Dosen ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    public function dataMahasiswaPerMKSemester($header, $app)
    {
        $tahun_akademik = $_POST['tahun_akademik'];
        $sem = $_POST['semester'];

        $group = " GROUP BY  a.NIM";
        if ($sem == "1")
            $semester = "Gasal";
        else
            $semester = "Genap";

        $tWhere = "";
        if (isset($_POST['kode_mk']))
            $tWhere .= " AND b.KdMK ='".$_POST['kode_mk']."'";
            
        if (isset($_POST['kode_kurikulum']))
            $tWhere .= " AND c.KdKonsentrasi ='".$_POST['kode_kurikulum']."'";

        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT 
            a.NIM as kode_mahasiswa, c.Nama as nama_mahasiswa, c.KdProdi as kode_prodi, c.KdFak as kode_fakultas, c.Kelas as kode_kelas
            FROM nilai a
            JOIN mahasiswa c
                ON a.NIM = c.NIM
            JOIN matakuliah b
                ON a.KdMK = b.KdMK AND b.KdKonsentrasi = c.KdKonsentrasi AND b.KdProdi = c.KdProdi
            WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere. $group);
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_mahasiswa'] = $row['kode_mahasiswa'];
                    $nestedData['nama_mahasiswa'] = $row['nama_mahasiswa'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['kode_kelas'] = $row['kode_kelas'];
                    // $nestedData['email'] = $row['email'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Mahasiswa ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    
    public function dataMahasiswaMKSemester($header, $app)
    {
        $tahun_akademik = $_POST['tahun_akademik'];
        $sem = $_POST['semester'];

        if ($sem == "1")
            $semester = "Gasal";
        else
            $semester = "Genap";

        $tWhere = "";
        if (isset($_POST['kode_mahasiswa']))
            $tWhere .= " AND b.NIM ='".$_POST['kode_mahasiswa']."'";
            
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT b.KdKonsentrasi as kode_kurikulum, a.KdMK as kode_mk, c.Matakuliah as nama_mk, c.SKS as sks, b.KdProdi as kode_prodi, d.Prodi as nama_prodi, b.KdFak as kode_fakultas, e.NamaUnit as nama_fakultas  FROM nilai a 
            JOIN mahasiswa b ON a.NIM = b.NIM 
            JOIN matakuliah c ON a.KdMK=c.KdMK AND b.KdKonsentrasi = c.KdKonsentrasi
            JOIN prodi d ON d.KdProdi = b.KdProdi
            JOIN unit e ON e.KdUnit = b.KdFak
            WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere);
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_kurikulum'] = $row['kode_kurikulum'];
                    $nestedData['kode_mk'] = $row['kode_mk'];
                    $nestedData['nama_mk'] = $row['nama_mk'];
                    $nestedData['sks'] = $row['sks'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['kode_fakultas'] = $row['kode_fakultas'];
                    $nestedData['nama_fakultas'] = $row['nama_fakultas'];
                    $hasil[] = $nestedData;
                }
                $data = array("status"=> 1,
                    "message"=> "data Mata Kuliah ditemukan",
                    "jumlah"=> count($hasil),
                    "data"=> $hasil,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    
    function dataDetailMK($header, $app)
    {
        $tahun_akademik = $_POST['tahun_akademik'];
        $sem = $_POST['semester'];
        if ($sem == "1")
            $semester = "Gasal";
        else
            $semester = "Genap";
        $tWhere = "";
        if (isset($_POST['kode_mk']))
            $tWhere .= " AND a.KdMK ='".$_POST['kode_mk']."'";
        
        if (isset($_POST['kode_kurikulum']))
            $tWhere .= " AND a.KdKonsentrasi ='".$_POST['kode_kurikulum']."'"; 
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT a.KdDosen as kode_dosen, c.Nama as nama_dosen, b.KdProdi as kode_prodi, d.Prodi as nama_prodi, b.Matakuliah as nama_mk, b.SKS as sks FROM makuldosen a 
            JOIN matakuliah b ON a.KdMK= b.KdMK AND a.KdKonsentrasi = b.KdKonsentrasi
            JOIN dosen c ON c.KdDosen = a.KdDosen
            JOIN prodi d ON d.KdProdi = b.KdProdi
            WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere . " GROUP BY a.KdDosen");
            
            $cekKelas=mysqli_query($this->koneksi,"SELECT a.KdDosen as kode_dosen, c.Nama as nama_dosen, a.Kelas as kelas FROM makuldosen a 
            JOIN dosen c ON c.KdDosen = a.KdDosen
            WHERE a.TA='".$tahun_akademik."' AND a.Smt='".$semester."' ".$tWhere . " GROUP BY a.Kelas");
            
            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    $nestedData['kode_dosen'] = $row['kode_dosen'];
                    $nestedData['nama_dosen'] = $row['nama_dosen'];
                    $nestedData['kode_prodi'] = $row['kode_prodi'];
                    $nestedData['sks'] = $row['sks'];
                    $nestedData['nama_prodi'] = $row['nama_prodi'];
                    $nestedData['nama_mk'] = $row['nama_mk'];
                    $hasil[] = $nestedData;
                }
                $hasil1 = array();
                if ($cekKelas){
                    while($row = mysqli_fetch_array($cekKelas)){
                        $nestedData1['kode_dosen'] = $row['kode_dosen'];
                        $nestedData1['nama_dosen'] = $row['nama_dosen'];
                        $nestedData1['kelas'] = $row['kelas'];
                        $hasil1[] = $nestedData1;
                    }
                }
                $data = array("status"=> 1,
                    "message"=> "data Mata Kuliah ditemukan",
                    "jumlah"=> count($hasil),
                    "dataDosen"=> $hasil,
                    "dataKelas"=> $hasil1,
                );
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
    function login($header, $app)
    {
        $user =''; $pass = '';
        if (isset($_POST['username']))
            $user = $_POST['username'];
        
        if (isset($_POST['password']))
            $pass = $_POST['password'];
        $proses = 0;
        if ($header == $this->token && $app == $this->appName)
            $proses = 1;
        $hasil = array();
        if ($proses == 1) {
            $cek=mysqli_query($this->koneksi,"SELECT * FROM dosen a
            JOIN prodiajardosen b ON a.KdDosen = b.KdDosen
            JOIN prodi c ON c.KdProdi = b.KdProdi 
            JOIN unit d ON d.KdUnit= c.KdUnit
            WHERE a.KdDosen = '".$user."' AND `Password` = '".$pass."' GROUP BY a.KdDosen");

            if ($cek){
                while($row = mysqli_fetch_array($cek)){
                    // $nestedData['usergroup'] = 'dosen';
                    // $nestedData['nama'] = $row['Nama'];
                    // $nestedData['nama_fakultas'] = $row['NamaUnit'];
                    // $nestedData['nama_prodi'] = $row['Prodi'];
                    // $nestedData['kode_fakultas'] = $row['KdUnit'];
                    // $hasil[] = $nestedData;
                    $data = array("status"=> 1,
                        "message"=> "Login Success",
                        'usergroup' => 'dosen',
                        'nama' =>$row['Nama'],
                        'nama_fakultas' => $row['NamaUnit'],
                        'nama_prodi' => $row['Prodi'],
                        'kode_prodi' => $row['KdProdi'],
                        'kode_fakultas' =>  $row['KdUnit'],
                    );
                }
                // $data = array("status"=> 1,
                //     "message"=> "Login Success",
                //     "jumlah"=> count($hasil),
                //     "data"=> $hasil,
                // );
                if (count($hasil) == 0){
                    $cekMhs=mysqli_query($this->koneksi,"SELECT * FROM mahasiswa a
                    JOIN prodi b ON a.KdProdi = b.KdProdi
                    JOIN unit c ON a.KdFak= c.KdUnit
                    WHERE a.NIM = '".$user."' AND `Password` = '".$pass."' GROUP BY a.NIM");
                    if ($cekMhs){
                        while($row = mysqli_fetch_array($cekMhs)){
                            $data = array("status"=> 1,
                                "message"=> "Login Success",
                                'usergroup' => 'mahasiswa',
                                'nama' =>$row['Nama'],
                                'nama_fakultas' => $row['NamaUnit'],
                                'kode_prodi' => $row['KdProdi'],
                                'nama_prodi' => $row['Prodi'],
                                'kode_fakultas' =>  $row['KdUnit'],
                            );
                        }
                        
                    }else{
                        $data = array(
                            "status" => 0,
                            "message" => "Data tidak ditemukan."
                        );
                    }
                }
            }else{
                $data = array(
                    "status" => 0,
                    "message" => "Data tidak ditemukan."
                );
            }
        }else{
            $data = array(
                "status" => 0,
                "message" => "Header dan App tidak sesuai."
            );
        }
        return $data;
    }
}

?>