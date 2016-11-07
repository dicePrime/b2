<?

$database = array(
	'b2b_des_requete'=>array(
							 'class' => '\AppBundle\Entity\B2BDesRequete', 
							 'table' => 'b2b_des_requete', 
							 'fields' => array('id'=>'id', 'nom'=>'nom', 'email'=>'email'),
							 'pk'=>'id'
							 ),

	'b2b_ligne_des_requete'=> array('class' => '\AppBundle\Entity\B2BLigneDesRequete', 
									'table' => 'b2b_ligne_des_requete',
									'fields' => array('id'=>'id', 'id_requete'=> 'idRequete', 'id_des'=>'idDes'),
									'pk'=> 'id'
									),
);