<?php
$title = "info";

include('../../include/wrapperstart.php');
?>

<p>


<?php
    //include the library
    include "libchart/libchart/classes/libchart.php";
 
    //new pie chart instance
    $chart = new PieChart( 700, 400 );
 
    //data set instance
    $dataSet = new XYDataSet();

 
    //query all records from the database
	$query = "";
    $query1 = "select COUNT(*) AS Male from `UserInfo` WHERE gender='M'";
	$query2 = "select COUNT(*) AS Female from `UserInfo` WHERE gender='F'";
	
 
    //execute the query
    $result1 = $mysqli->query( $query1 );
	$result2 = $mysqli->query( $query2 );
 /*
    //get number of rows returned
    $num_results = $result->num_rows;
 
    if( $num_results > 0){
    
        while( $row = $result->fetch_assoc() ){
            extract($row);
            $dataSet->addPoint(new Point("{$user_id} {$nationality})", $nationality));
        }
  */  
        $row1 = $result1->fetch_assoc();
		$row2 = $result2->fetch_assoc();
        extract($row1);
		extract($row2);
        $dataSet->addPoint(new Point("'Male' {$Male})", $Male));
		$dataSet->addPoint(new Point("'Female' {$Female})", $Female));
        //finalize dataset
        $chart->setDataSet($dataSet);
 
        //set chart title
        $chart->setTitle("Percentage of users per gender");
        
        //render as an image and store under "generated" folder
        $chart->render("img/1.png");
    
        //pull the generated chart where it was stored
        echo "<img alt='Pie chart'  src='img/1.png' style='border: 1px solid gray;'/>";
    
    
?>
<br><br>
<?php
    
 
    //new pie chart instance
    $chart = new PieChart( 700, 400 );
 
    //data set instance
    $dataSet = new XYDataSet();
    
 
    //query all records from the database
	$query3 = "select DISTINCT nationality as Nationality from `UserInfo`";
    $query4 = "select COUNT(nationality) AS Country from `UserInfo` GROUP BY nationality";
	
	
 
    //execute the query
    $result3 = $mysqli->query( $query3 );
	$result4 = $mysqli->query( $query4 );

    //get number of rows returned
    $num_results = $result3->num_rows;
 
    if( $num_results > 0){
    
        while( $row3 = $result3->fetch_assoc() ){
			$row4 = $result4->fetch_assoc();
            extract($row3);
			extract($row4);
            $dataSet->addPoint(new Point("'{$Nationality}' {$Country}", $Country));
			
       
       
        //$dataSet->addPoint(new Point("{'UK'} {$British})", $British));
		//$dataSet->addPoint(new Point("{'Germany'} {$German})", $German));
        }
		 
	}
        //finalize dataset
        $chart->setDataSet($dataSet);
  
        //set chart title
        $chart->setTitle("Percentage of users per country");
        
        //render as an image and store under "generated" folder
        $chart->render("img/2.png");
    
        //pull the generated chart where it was stored
        echo "<img alt='Pie chart'  src='img/2.png' style='border: 1px solid gray;'/>";
		
?>
</p>

<?php
include('../../include/wrapperend.php');
?>