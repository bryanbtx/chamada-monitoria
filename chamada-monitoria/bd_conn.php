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
	function disconnectFromDB(){
		$this->con->close();
	}
	function selectUsuario($ra,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("select * from TABFA4_W_MONITOR where NM_RA=? and NM_SENHA=? and ST_DELETADO=0;");
		$stmt->bind_param("ss",$ra,$senha);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function selectUsuarioByRA($ra){
		$stmt=$this->con->prepare("select * from TABFA4_W_MONITOR where NM_RA=? and ST_DELETADO=0;");
		$stmt->bind_param("s",$ra);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function alterUsuarioSenhaTrocar($ra,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("update TABFA4_W_MONITOR set NM_SENHA=?,ST_TROCAR_SENHA=1 where NM_RA=? and ST_DELETADO=0;");
		$stmt->bind_param("ss",$senha,$ra);
		return $stmt->execute();
	}
	function insertUsuario($ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("insert into TABFA4_W_MONITOR values(null,?,?,?,?,0,?,?,?,0);");
		$stmt->bind_param("sssssss",$ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso);
		return $stmt->execute();
	}
	function alterUsuarioSenha($id,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("update TABFA4_W_MONITOR set NM_SENHA=?,ST_TROCAR_SENHA=0 where ID_MONI_SEC=? and ST_DELETADO=0;");
		$stmt->bind_param("si",$senha,$id);
		return $stmt->execute();
	}
	function alterUsuarioInfo($id,$ra,$nome,$email,$prof_resp,$disciplina,$curso){
		$unique=true;
		$string="update TABFA4_W_MONITOR set ";

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
		$string.=" where ID_MONI_SEC=".$id." and ST_DELETADO=0;";
		$stmt=$this->con->prepare($string);
		return $stmt->execute();
	}
	function selectUsuarioAll(){
		$stmt=$this->con->prepare("select * from TABFA4_W_MONITOR where ST_DELETADO=0 order by NM_RA;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function insertHora($id,$dia_semana,$hora_inicio,$hora_termino){
		$stmt=$this->con->prepare("insert into TABFA4_W_HORARIO values(null,?,?,?,?,0);");
		$stmt->bind_param("iiss",$id,$dia_semana,$hora_inicio,$hora_termino);
		return $stmt->execute();
	}
	function selectHorariosAll(){
		$stmt=$this->con->prepare("select * from TABFA4_W_HORARIO where ST_DELETADO=0 order by CS_DIA;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function deleteHora($id_ho){
		$stmt=$this->con->prepare("update TABFA4_W_HORARIO set ST_DELETADO=1 where ID_HORA_SEC=?;");
		$stmt->bind_param("i",$id_ho);
		return $stmt->execute();
	}
	function insertAlunos($id_moni,$nome,$curso){
		$stmt=$this->con->prepare("insert into TABFA4_W_ALUNO values(null,?,?,?,0);");
		$stmt->bind_param("iss",$id_moni,$nome,$curso);
		return $stmt->execute();
	}
	function insertPresenca($id_al,$id_mo,$data_cha,$obs){
		$stmt=$this->con->prepare("insert into TABFA4_W_PRESENCA values(null,?,?,?,?,0);");
		$stmt->bind_param("iiss",$id_al,$id_mo,$data_cha,$obs);
		return $stmt->execute();
	}
	function selectHorarioById_mo($id_mo){
		$stmt=$this->con->prepare("select * from TABFA4_W_HORARIO where FK_HORARIO_MONITOR=? and ST_DELETADO=0 order by CS_DIA;");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectChamada($id_mo){
		$stmt=$this->con->prepare("select ID_PRES_SEC,FK_HORARIO_MONITOR,DT_PRESENCA,CS_DIA,HR_INICIO,HR_TERMINO,NM_NOME,DS_OBS from ((TABFA4_W_PRESENCA left join TABFA4_W_HORARIO on FK_PRESENCA_HORARIO=ID_HORA_SEC) left  join TABFA4_W_ALUNO on FK_PRESENCA_ALUNO=ID_ALUN_SEC) where FK_HORARIO_MONITOR=?  and TABFA4_W_ALUNO.ST_DELETADO=0 and TABFA4_W_HORARIO.ST_DELETADO=0 order by DT_PRESENCA,CS_DIA,NM_NOME");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectChamadaAll(){
		$stmt=$this->con->prepare("select ID_PRES_SEC,DT_PRESENCA,CS_DIA,HR_INICIO,HR_TERMINO,NM_NOME,DS_OBS from ((TABFA4_W_PRESENCA left join TABFA4_W_HORARIO on FK_PRESENCA_HORARIO=ID_HORA_SEC) left join TABFA4_W_ALUNO on FK_PRESENCA_ALUNO=ID_ALUN_SEC) where ST_DELETADO=0 order by DT_PRESENCA,CS_DIA,NM_NOME");
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectQtdAluno($id_mo){
		$stmt=$this->con->prepare('select count(*)"qtd" from TABFA4_W_ALUNO where FK_ALUNO_MONITOR=? and ST_DELETADO=0;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function selectInfoAll(){
		$stmt=$this->con->prepare('select ID_MONI_SEC,NM_NOME,NM_EMAIL,NM_PROF_RESPONSAVEL,NM_DISCIPLINA,NM_CURSO,(select count(*) from TABFA4_W_ALUNO where FK_ALUNO_MONITOR=ID_MONI_SEC and ST_DELETADO=0)"qtd" from TABFA4_W_MONITOR where ST_DELETADO=0 order by NM_NOME;');
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectQtdPresenca($id_mo){
		$stmt=$this->con->prepare('select NM_NOME,(select count(*) from TABFA4_W_PRESENCA where FK_PRESENCA_ALUNO=ID_ALUN_SEC)"qtd" from TABFA4_W_ALUNO,TABFA4_W_HORARIO where FK_ALUNO_MONITOR=? and TABFA4_W_ALUNO.ST_DELETADO=0 and TABFA4_W_HORARIO.ST_DELETADO=0 order by NM_NOME;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function deleteMonitor($id_mo){
		$stmt=$this->con->prepare("update TABFA4_W_MONITOR set ST_DELETADO=1 where ID_MONI_SEC=?;");
		$stmt->bind_param("i",$id_mo);
		return $stmt->execute();
	}
	function deleteAluno($id_al,$status){
		$stmt=$this->con->prepare("update TABFA4_W_ALUNO set ST_DELETADO=? where ID_ALUN_SEC=?;");
		$stmt->bind_param("ii",$status,$id_al);
		return $stmt->execute();
	}
}
?>
