<?php

function shorten($output, $limit = 120)
{
	$output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
	if (strlen($output) > $limit)
	{
		$output = substr($output, 0, $limit) . ' <a>...</a>';
	}

	echo $output;
}

?>

<?php

function shortenmenu($output, $limit = 27)
{
	$output = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
	if (strlen($output) > $limit)
	{
		$output = substr($output, 0, $limit) . ' <a>...</a>';
	}

	echo $output;
}

?>

<?php

function breadcrumbs($separator = ' &raquo; ', $home = 'Home')
{
	$path = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
	$base_url = substr($_SERVER['SERVER_PROTOCOL'], 0, strpos($_SERVER['SERVER_PROTOCOL'], '/')) . '://' . $_SERVER['HTTP_HOST'] . '/';
	$breadcrumbs = array(
		"<a href=\"$base_url\">$home</a>"
	);
	$tmp = array_keys($path);
	$last = end($tmp);
	unset($tmp);
	foreach($path as $x => $crumb)
	{
		$title = ucwords(str_replace(array(
			'.php',
			'_'
		) , array(
			'',
			' '
		) , $crumb));
		if ($x == 1)
		{
			$breadcrumbs[] = "<a href=\"$base_url$crumb\">$title</a>";
		}
		elseif ($x > 1 && $x < $last)
		{
			$tmp = "<a href=\"$base_url";
			for ($i = 1; $i <= $x; $i++)
			{
				$tmp.= $path[$i] . '/';
			}

			$tmp.= "\">$title</a>";
			$breadcrumbs[] = $tmp;
			unset($tmp);
		}
		else
		{
			$breadcrumbs[] = "$title";
		}
	}

	return implode($separator, $breadcrumbs);
}

?>



 <script>
 function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    } else {
        document.getElementById("myBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
} 
</script>


 
