<?php

DEFINE ("TOKEN","1dabb5830112613eaf18aa423a79d3b7");
DEFINE ("DOMAIN","https://localhost/03_moodle");

require_once('./curl.php');

class hartoto{
	var $host = "sia.unm.ac.id";
	var $username = "";
	var $password = "";
	var $database = "gamelan_unm";
	var $koneksi = "";
	function __construct(){
		$this->koneksi = mysqli_connect($this->host, $this->username, $this->password,$this->database);
		if (mysqli_connect_errno()){
			echo "Koneksi database gagal : " . mysqli_connect_error();
			die;
		}
	}
 
	function tampil_user()
	{
		$data = mysqli_query($this->koneksi,"
		SELECT
			t_mst_user_login.C_USERNAME AS USERNAME,
			t_mst_user_login.PASSWORD_X AS PASSWORD,
			CONCAT ( t_mst_user_login.C_USERNAME, '@unm.ac.id' ) AS EMAIL,
			t_mst_user_login.C_KODE_JENIS_USER AS STATUS,
			t_mst_dosen.NAMA_DOSEN AS NAMA,
			t_mst_dosen.C_KODE_PRODI AS PRODI,
			t_mst_prodi.C_KODE_FAKULTAS AS FAKULTAS 
		FROM
			t_mst_user_login,
			t_mst_dosen,
			t_mst_prodi 
		WHERE
			C_KODE_JENIS_USER = 'dosen' 
			AND STATUS_USER = 1 
			AND t_mst_user_login.C_USERNAME = t_mst_dosen.C_KODE_DOSEN 
			AND t_mst_dosen.C_KODE_PRODI = t_mst_prodi.C_KODE_PRODI 
			LIMIT 0,5");
		while($row = mysqli_fetch_array($data)){
			$hasil[] = $row;
		}
		return $hasil;
	}
	function buat_user($user){
		if (!$user){
			die ("USERNAME kosong");
		}
		//cek status user
		$cek=mysqli_query($this->koneksi,"
		SELECT 
			t_mst_user_login.C_KODE_JENIS_USER
		FROM 
			t_mst_user_login
		WHERE
			t_mst_user_login.C_USERNAME = '$user'");
		//var_dump($user);
		//var_dump($cek);
	
		if ($cek){
			$status = mysqli_fetch_array($cek);
			$sh=$status['C_KODE_JENIS_USER'];

			if ($sh=="dosen"){
				$data = mysqli_query($this->koneksi,"
					SELECT
						t_mst_user_login.C_USERNAME AS USERNAME,
						t_mst_user_login.PASSWORD_X AS PASSWORD,
						CONCAT ( t_mst_user_login.C_USERNAME, '@unm.ac.id' ) AS EMAIL,
						t_mst_user_login.C_KODE_JENIS_USER AS STATUS,
						t_mst_dosen.NAMA_DOSEN AS NAMA,
						t_mst_dosen.C_KODE_PRODI AS PRODI,
						t_mst_prodi.C_KODE_FAKULTAS AS FAKULTAS 
					FROM
						t_mst_user_login,
						t_mst_dosen,
						t_mst_prodi 
					WHERE
						t_mst_user_login.C_USERNAME = '$user' 
						AND t_mst_user_login.STATUS_USER = 1 
						AND t_mst_user_login.C_USERNAME = t_mst_dosen.C_KODE_DOSEN
						AND t_mst_dosen.C_KODE_PRODI = t_mst_prodi.C_KODE_PRODI");
				$hasil = mysqli_fetch_array($data);
				//return $hasil;
			}elseif ($sh=="mahasiswa"){
				$data = mysqli_query($this->koneksi,"
					SELECT
						t_mst_user_login.C_USERNAME AS USERNAME,
						t_mst_user_login.PASSWORD_X AS PASSWORD,
						CONCAT ( t_mst_user_login.C_USERNAME, '@student.unm.ac.id' ) AS EMAIL,
						t_mst_user_login.C_KODE_JENIS_USER AS STATUS,
						t_mst_mahasiswa.NAMA_MAHASISWA AS NAMA,
						t_mst_mahasiswa.C_KODE_PRODI AS PRODI,
						t_mst_mahasiswa.C_KODE_FAKULTAS AS FAKULTAS 
					FROM
						t_mst_user_login,
						t_mst_mahasiswa
					WHERE
						t_mst_user_login.C_USERNAME = '$user' 
						AND t_mst_user_login.STATUS_USER = 1 
						AND t_mst_user_login.C_USERNAME = t_mst_mahasiswa.C_NPM");
				$hasil = mysqli_fetch_array($data);
				$data = array('users' => $user);
				//return $hasil;
			}
			//injeksi user
			$user= new stdClass();
			$user->username = strtolower($hasil['USERNAME']);
			$user->password = $hasil['PASSWORD'];
			$user->firstname = $hasil['USERNAME'];
			$user->lastname = $hasil['NAMA'];
			$user->email = $hasil['EMAIL'];
			$user->auth = 'manual';
			$user->idnumber = $hasil['USERNAME'];
			$user->institution = $hasil['FAKULTAS'];
			$user->department = $hasil['PRODI'];
			$user = array($user);
			$data = array('users' => $user);

			header('Content-Type: text/plain');
			$buatakun = DOMAIN . '/webservice/rest/server.php'. '?wstoken=' . TOKEN . '&moodlewsrestformat=json&wsfunction=core_user_create_users';

			$curl = new curl;
			$injek = $curl->post($buatakun, $data);
			
			//cek status injek
			if (strlen($injek) > 100){
				$pesan= $hasil['USERNAME']." - gagal";
			} else {
				$pesan=$hasil['USERNAME']." - sukses";
			}
		$this->koneksi -> close();
		return $pesan;
		}
	}
	function peserta(){
		echo "dev";
	}
	function buat_kelas($kode){
		//set variabel
		$mulai= strtotime('2021-01-20');
		$selesai= strtotime('2021-12-30 23:59:59');
		$grup=3;
		
		
		$course= new stdClass();
		$course->fullname="Hanif Atha Pradipta";
		$course->shortname=$kode;
		$course->categoryid=1;
		$course->idnumber=$kode;
		$course->startdate=$mulai;
		$course->enddate=$selesai;
		$course->numsections=16; //deprecated
		$course->groupmode=2; //0=no group 1= visible group 2= separate group
		$course->showreports=1;
		$course->enablecompletion=1;
		
		$course = array($course);
		$data = array('courses' => $course);
		
		header('Content-Type: text/plain');
			$buatkelas = DOMAIN . '/webservice/rest/server.php'. '?wstoken=' . TOKEN . '&moodlewsrestformat=json&wsfunction=core_course_create_courses';
		
		$curl = new curl;
		$injek = $curl->post($buatkelas, $data);
		
		//var_dump($injek);		
		//cek status injek
		if (strlen($injek) > 100){
			$pesan= $kode." - gagal";
		} else {
			$pesan=$kode." - sukses";
		}
		return $pesan;
	}
	function enroll_peserta(){
		
	}
	
	function buat_kategori(){
		
		//cari fakultas di DB
		$fakc=mysqli_query($this->koneksi,"
		SELECT 
			t_mst_fakultas.C_KODE_FAKULTAS as idnumber,
			t_mst_fakultas.NAMA_FAKULTAS as name
		FROM 
			t_mst_fakultas
		ORDER BY
			t_mst_fakultas.C_KODE_FAKULTAS");
		$i=1;
		while ($fak = mysqli_fetch_assoc($fakc)){
			$cat[$i]=array(
			'name'=>$fak['name'],
			'idnumber'=>$fak['idnumber'],
			'parent'=>0);
		$i++;
		}

		$data = array('categories' => $cat);
				
		header('Content-Type: text/plain');
		$buatkategori = DOMAIN . '/webservice/rest/server.php'. '?wstoken=' . TOKEN . '&moodlewsrestformat=json&wsfunction=core_course_create_categories';
		
		
		$curl = new curl;
		$injek = $curl->post($buatkategori, $data);
		
		//cek status injek
		//string(127) "{"exception":"moodle_exception","errorcode":"categoryidnumbertaken","message":"ID number is already used for another category"}"
		//die ("disini");
		if (strlen($injek)== 127 ){ 
			$pesan= "gagal";
		} else {
			$pesan="sukses";
			
			$idfak=json_decode($injek);
			var_dump ($injek);
			var_dump ($idfak);
			$k=1;
			
			for($x=0;$x<$i;$x++){
				$kodefak= $idfak[$x]->id;
				$idfak= $idfak[$x]->name;
				print_r($kodefak);
				print_r ($idfak);
				die;
				
				$prodc=mysqli_query($this->koneksi,"
					SELECT
						t_mst_prodi.C_KODE_FAKULTAS,
						t_mst_fakultas.NAMA_FAKULTAS,
						t_mst_prodi.C_KODE_PRODI as idnumber,
						t_mst_prodi.NAMA_PRODI as name
					FROM
						t_mst_prodi,
						t_mst_fakultas
					ORDER BY
						t_mst_prodi.C_KODE_FAKULTAS,
						t_mst_prodi.C_KODE_PRODI
					t_mst_prodi.C_KODE_FAKULTAS=t_mst_fakultas.C_KODE_FAKULTAS
					WHERE t_mst_prodi.C_KODE_FAKULTAS='$kodefak'");
				while ($prodi = mysqli_fetch_assoc($prodc)){
					$prod[$k]=array(
					'name'=>$prodi['name'],
					'idnumber'=>$prodi['idnumber'],
					'parent'=>$idfak);
				$k++;
				}
			}
			
			//eksekusi prodi
			$data = array('categories' => $prod);
			$injek = $curl->post($buatkategori, $data);
			
			var_dump($injek);
			if (strlen($injek)== 127 ){ 
				$pesan= "gagal";
			} else {
				$pesan="sukses";
			}
		}
		//masukkan 
		return $pesan;
	}
	function baca_kategori(){

		header('Content-Type: text/plain');
		$baca_kategori = DOMAIN . '/webservice/rest/server.php'. '?wstoken=' . TOKEN . '&moodlewsrestformat=json&wsfunction=core_course_get_categories&criteria[0][key]=parent&criteria[0][value]=0';
		
		$curl = new curl;
		$injek = $curl->post($baca_kategori);
		//print_r($injek);
		
		$hasil = json_decode($injek);

		//print_r($rows[0]->id);
		//print_r ($hasil);
		for($i=0;$i<count($hasil);$i++){
			echo $hasil[$i]->id .":" .$hasil[$i]->idnumber.":".$hasil[$i]->name;
			echo "\n";
		}
		
	}
}

//eksekusi
$api = new hartoto();
//$bu = $api->buat_user("14B07146");
//$bu = $api->buat_user("201051301072");
//$bu = $api->buat_user("PPSUNM003");
//$bu = $api->buat_user("0011118703");
//echo ($bu);

/*$bk= $api->buat_kelas("123");
echo ($bk);*/

$cat=$api->buat_kategori();
echo ($cat);
//$bcat=$api->baca_kategori();
//echo ($bcat)
?>