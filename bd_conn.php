<?php
class bd_conn{
	private $con;
	public $errorCode=0;
	function __construct(){
		include_once __DIR__.'/constants.php';
		$this->con=new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		if(mysqli_connect_errno()){
			echo "Erro na conexão: ".mysqli_connect_err();
		}
	}
	function disconnectFROMDB(){
		$this->con->close();
	}
	function SELECTUsuario($ra,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("SELECT * FROM TABFA4_W_MONITOR WHERE NM_RA=? AND NM_SENHA=?;");
		$stmt->bind_param("ss",$ra,$senha);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function SELECTUsuarioByRA($ra){
		$stmt=$this->con->prepare("SELECT * FROM TABFA4_W_MONITOR WHERE NM_RA=?;");
		$stmt->bind_param("s",$ra);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function alterUsuarioSenhaTrocar($ra,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("UPDATE TABFA4_W_MONITOR SET NM_SENHA=?,ST_TROCAR_SENHA=1 WHERE NM_RA=?;");
		$stmt->bind_param("ss",$senha,$ra);
		return $stmt->execute();
	}
	function INSERTUsuario($ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("INSERT INTO TABFA4_W_MONITOR VALUES(null,?,?,?,?,0,?,?,?,1);");
		$stmt->bind_param("sssssss",$ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso);
		return $stmt->execute();
	}
	function alterUsuarioSenha($id,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("UPDATE TABFA4_W_MONITOR SET NM_SENHA=?,ST_TROCAR_SENHA=0 WHERE ID_MONI_SEC =?;");
		$stmt->bind_param("si",$senha,$id);
		return $stmt->execute();
	}
	function alterUsuarioInfo($id,$ra,$nome,$email,$prof_resp,$disciplina,$curso){
		$unique=true;
		$string="UPDATE TABFA4_W_MONITOR SET ";

		if($ra!=""){
			$string.='NM_RA="'.$ra.'"';
			$unique=false;
		}
		if($nome!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='NM_NOME="'.$nome.'"';
			$unique=false;
		}
		if($email!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='NM_EMAIL="'.$email.'"';
			$unique=false;
		}
		if($prof_resp!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='NM_PROF_RESPONSAVEL="'.$prof_resp.'"';
			$unique=false;
		}
		if($disciplina!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='NM_DISCIPLINA="'.$disciplina.'"';
			$unique=false;
		}
		if($curso!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='NM_CURSO="'.$curso.'"';
		}
		$string.=" WHERE ID_MONI_SEC=".$id;
		$stmt=$this->con->prepare($string);
		return $stmt->execute();
	}
	function SELECTUsuarioAll(){
		$stmt=$this->con->prepare("SELECT * FROM TABFA4_W_MONITOR ORDER BY NM_RA;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function INSERTHora($id,$dia_semana,$hora_inicio,$hora_termino){
		$stmt=$this->con->prepare("INSERT INTO TABFA4_W_HORARIO VALUES(null,?,?,?,?,1);");
		$stmt->bind_param("iiss",$id,$dia_semana,$hora_inicio,$hora_termino);
		return $stmt->execute();
	}
	function SELECTHorariosAll(){
		$stmt=$this->con->prepare("SELECT * FROM TABFA4_W_HORARIO ORDER BY CS_DIA;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function deleteHora($id_ho){
		$stmt=$this->con->prepare("UPDATE TABFA4_W_HORARIO SET ST_STATUS=1 WHERE ID_HORA_SEC=?;");
		$stmt->bind_param("i",$id_ho);
		return $stmt->execute();
	}
	function INSERTAlunos($id_moni,$nome,$curso){
		$stmt=$this->con->prepare("INSERT INTO TABFA4_W_ALUNO VALUES(null,?,?,?);");
		$stmt->bind_param("iss",$id_moni,$nome,$curso);
		return $stmt->execute();
	}
	function INSERTPresenca($id_al,$id_mo,$data_cha,$obs){
		$stmt=$this->con->prepare("INSERT INTO TABFA4_W_PRESENCA VALUES(null,?,?,?,?);");
		$stmt->bind_param("iiss",$id_al,$id_mo,$data_cha,$obs);
		return $stmt->execute();
	}
	function SELECTHorarioById_mo($id_mo){
		$stmt=$this->con->prepare("SELECT * FROM TABFA4_W_HORARIO WHERE FK_HORARIO_MONITOR=? ORDER BY CS_DIA;");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function SELECTChamada($id_mo){
		$stmt=$this->con->prepare("SELECT ID_PRES_SEC,FK_HORARIO_MONITOR,DT_PRESENCA,CS_DIA,HR_INICIO,HR_TERMINO,NM_NOME,DS_OBS FROM ((TABFA4_W_PRESENCA LEFT JOIN TABFA4_W_HORARIO ON FK_PRESENCA_HORARIO=ID_HORA_SEC) LEFT JOIN TABFA4_W_ALUNO ON FK_PRESENCA_ALUNO=ID_ALUN_SEC) WHERE FK_HORARIO_MONITOR=? ORDER BY DT_PRESENCA,CS_DIA,NM_NOME");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function SELECTChamadaAll(){
		$stmt=$this->con->prepare("SELECT ID_PRES_SEC,DT_PRESENCA,CS_DIA,HR_INICIO,HR_TERMINO,NM_NOME,DS_OBS FROM ((TABFA4_W_PRESENCA LEFT JOIN TABFA4_W_HORARIO ON FK_PRESENCA_HORARIO=ID_HORA_SEC) LEFT JOIN TABFA4_W_ALUNO ON FK_PRESENCA_ALUNO=ID_ALUN_SEC) ORDER BY DT_PRESENCA,CS_DIA,NM_NOME");
		$stmt->execute();
		return $stmt->get_result();
	}
	function SELECTQtdAluno($id_mo){
		$stmt=$this->con->prepare('SELECT COUNT(*)"qtd" FROM TABFA4_W_ALUNO WHERE FK_ALUNO_MONITOR=?;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function SELECTInfoAll(){
		$stmt=$this->con->prepare('SELECT ID_MONI_SEC,NM_NOME,NM_EMAIL,NM_PROF_RESPONSAVEL,NM_DISCIPLINA,NM_CURSO,(SELECT COUNT(*) FROM TABFA4_W_ALUNO WHERE FK_ALUNO_MONITOR=ID_MONI_SEC)"qtd" FROM TABFA4_W_MONITOR ORDER BY NM_NOME;');
		$stmt->execute();
		return $stmt->get_result();
	}
	function SELECTQtdPresenca($id_mo){
		$stmt=$this->con->prepare('SELECT NM_NOME,(SELECT COUNT(*) FROM TABFA4_W_PRESENCA WHERE FK_PRESENCA_ALUNO=ID_ALUN_SEC)"qtd" FROM TABFA4_W_ALUNO WHERE FK_ALUNO_MONITOR=? ORDER BY NM_NOME;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function deleteMonitor($id_mo){
		$stmt=$this->con->prepare("UPDATE TABFA4_W_MONITOR SET ST_STATUS=1 WHERE ID_MONI_SEC=?;");
		$stmt->bind_param("i",$id_mo);
		return $stmt->execute();
	}
}
?>
