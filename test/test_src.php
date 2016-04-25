<?php 
$name = "Yang Qing-rong";
$text = "the \"wudimei\" is Yang's website.";
$age = 32;

class Person{
	public $name;
	public $age;
	public function __construct($name,$age){
		$this->name = $name;
		$this->age = $age;
	}
	public function setName( $name){
		$this->name = $name;
	}
	
	public function getName(  ){
		return $this->name ;
	}
}

$p = new Person($name,$age);
echo $p->getName();

?>

<?php 
$i =0;
$i++;
while( $i<10){
	$i++;
}
if( $i>=10 ){
	echo "gt 10<br />";
}
for( $i=0;$i<3;$i++){
	echo $i;
}
?>