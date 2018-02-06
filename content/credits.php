<?php
include('header.php');
include('dbconn.php');
include('functions.php');
if (array_key_exists('username', $_SESSION) && array_key_exists('password', $_SESSION)) {
    $username = $_SESSION['username'];
    
} else {
    header('Location: ../content/login.php');
}
?>
 
    <div class ="breadcrumb">
    <ul>
    <?php
echo breadcrumbs();
?>
   </ul> 
    </div>
	<div id="references">
	<h1> Lala Rukh w16042081 </h1>
	<h2> References </h2>
	<p> W3schools.com. (2017). W3Schools Online Web Tutorials. [online] Available at: http://www.w3schools.com [Accessed 7 Dec. 2017].</p>
	<p> Visitmanchester.com. (2017). Visit Manchester - The official tourism website for Greater Manchester - Visit Manchester. [online] Available at: https://www.visitmanchester.com/ [Accessed 7 Dec. 2017]. <br />
		(Images in activities pages and plan your journey links in main page )</p>
	<p> Simple dynamic breadcrumb. [online] Stackoverflow.com. Available at: https://stackoverflow.com/questions/2594211/simple-dynamic-breadcrumb [Accessed 7 Dec. 2017]. <br />
		(breadcrumbs code) </p>
	<p> Anon, (2017). [online] Available at: https://www.freelogoservices.co/ [Accessed 7 Dec. 2017]. <br /> (Logo for this site) </p>
	<p> W3schools.com. (2017). How To Create a Scroll Back To Top Button. [online] Available at: https://www.w3schools.com/howto/howto_js_scroll_to_top.asp [Accessed 7 Dec. 2017]. 
	<br /> (Scroll back to top button in javascript) </p>
	<p> Photoeverywhere.co.uk. (2017). Free Stock photos of manchester | Photoeverywhere. [online] Available at: http://www.photoeverywhere.co.uk/britain/manchester/ [Accessed 7 Dec. 2017].</p>
	<p> Pixabay.com. (2017). Manchester - Free pictures on Pixabay. [online] Available at: https://pixabay.com/en/photos/manchester/ [Accessed 7 Dec. 2017].</p>
	<p> Flaticon. (2017). Flaticon, the largest database of free vector icons. [online] Available at: https://www.flaticon.com/ [Accessed 7 Dec. 2017]. </p>
	<p>Owlcation. (2017). Simple Search Using PHP and MySQL. [online] Available at: https://owlcation.com/stem/Simple-search-PHP-MySQL [Accessed 7 Dec. 2017].</p>
	<p>Php.net. (2017). PHP: Prepared Statements - Manual. [online] Available at: http://php.net/manual/en/mysqli.quickstart.prepared-statements.php [Accessed 7 Dec. 2017].</p>
	<p>W3schools.com. (2017). PHP Prepared Statements. [online] Available at: https://www.w3schools.com/php/php_mysql_prepared_statements.asp [Accessed 7 Dec. 2017].</p>
	<p>Material Palette - Material Design Color Palette Generator. (2017). Material Palette - Material Design Colors. [online] Available at: https://www.materialpalette.com/colors [Accessed 7 Dec. 2017].</p>


	
	
	</div>