<?php
class bd_conn{
	//da uns ORDER nos select :)
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
		$stmt=$this->con->prepare("select * from monitor where ra=? and senha=?;");
		$stmt->bind_param("ss",$ra,$senha);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function selectUsuarioByRA($ra){
		$stmt=$this->con->prepare("select * from monitor where ra=?;");
		$stmt->bind_param("s",$ra);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function alterUsuarioSenhaTrocar($ra,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("update monitor set senha=?,troca_senha=1 where ra=?;");
		$stmt->bind_param("ss",$senha,$ra);
		return $stmt->execute();
	}
	function insertUsuario($ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("insert into monitor values(null,?,?,?,?,0,?,?,?);");
		$stmt->bind_param("sssssss",$ra,$nome,$email,$senha,$prof_resp,$disciplina,$curso);
		return $stmt->execute();
	}
	function alterUsuarioSenha($id,$senha){
		$senha=hash('sha512', $senha);
		$stmt=$this->con->prepare("update monitor set senha=?,troca_senha=0 where id_mo=?;");
		$stmt->bind_param("si",$senha,$id);
		return $stmt->execute();
	}
	function alterUsuarioInfo($id,$ra,$nome,$email,$prof_resp,$disciplina,$curso){
		$unique=true;
		$string="update monitor set ";

		if($ra!=""){
			$string.='ra="'.$ra.'"';
			$unique=false;
		}
		if($nome!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='nome="'.$nome.'"';
			$unique=false;
		}
		if($email!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='email="'.$email.'"';
			$unique=false;
		}
		if($prof_resp!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='prof_resp="'.$prof_resp.'"';
			$unique=false;
		}
		if($disciplina!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='disciplina="'.$disciplina.'"';
			$unique=false;
		}
		if($curso!=""){
			if(!$unique){
				$string.=",";
			}
			$string.='curso="'.$curso.'"';
		}
		$string.=" where id_mo=".$id;
		$stmt=$this->con->prepare($string);
		return $stmt->execute();
	}
	function selectUsuarioAll(){
		$stmt=$this->con->prepare("select * from monitor;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function insertHora($id,$dia_semana,$hora_inicio,$hora_termino){
		$stmt=$this->con->prepare("insert into horario values(null,?,?,?,?);");
		$stmt->bind_param("iiss",$id,$dia_semana,$hora_inicio,$hora_termino);
		return $stmt->execute();
	}
	function selectHorariosAll(){
		$stmt=$this->con->prepare("select * from horario;");
		$stmt->execute();
		return $stmt->get_result();
	}
	function deleteHora($id_ho){
		$stmt=$this->con->prepare("delete from horario where id_ho=?;");
		$stmt->bind_param("i",$id_ho);
		return $stmt->execute();
	}
	function insertAlunos($id_moni,$nome){
		$stmt=$this->con->prepare("insert into aluno values(null,?,?);");
		$stmt->bind_param("is",$id_moni,$nome);
		return $stmt->execute();
	}
	function insertPresenca($id_al,$id_mo,$data_cha,$obs){
		$stmt=$this->con->prepare("insert into presenca values(null,?,?,?,?);");
		$stmt->bind_param("iiss",$id_al,$id_mo,$data_cha,$obs);
		return $stmt->execute();
	}
	function selectHorarioById_mo($id_mo){
		$stmt=$this->con->prepare("select * from horario where id_ho_mo=?;");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectChamada($id_mo){
		$stmt=$this->con->prepare("select id_pr,id_ho_mo,data_pre,dia_semana,hora_inicio,hora_termino,nome,obs from ((presenca left join horario on id_pr_ho=id_ho) left  join aluno on id_pr_al=id_al) where id_ho_mo=? order by data_pre,dia_semana,nome");
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectChamadaAll(){
		$stmt=$this->con->prepare("select id_pr,data_pre,dia_semana,hora_inicio,hora_termino,nome,obs from ((presenca left join horario on id_pr_ho=id_ho) left  join aluno on id_pr_al=id_al) order by data_pre,dia_semana,nome");
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectDiatodo($id_mo){
		$stmt=$this->con->prepare("select distinct presenca.data_pre from presenca inner join aluno on presenca.id_pr_al=aluno.id_al where aluno.id_al_mo=".$id_mo.";");
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectQtdAluno($id_mo){
		$stmt=$this->con->prepare('select count(*)"qtd" from aluno where id_al_mo=?;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result()->fetch_assoc();
	}
	function selectInfoAll(){
		$stmt=$this->con->prepare('select id_mo,nome,email,prof_resp,disciplina,curso,(select count(*) from aluno where id_al_mo=id_mo)"qtd" from monitor;');
		$stmt->execute();
		return $stmt->get_result();
	}
	function selectQtdPresenca($id_mo){
		$stmt=$this->con->prepare('select nome,(select count(*) from presenca where id_pr_al=id_al)"qtd" from aluno where id_al_mo=?;');
		$stmt->bind_param("i",$id_mo);
		$stmt->execute();
		return $stmt->get_result();
	}
}
?>
