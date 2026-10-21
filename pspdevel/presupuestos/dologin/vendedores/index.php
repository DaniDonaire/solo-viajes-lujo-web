<?php
	require '../include/verifLogin.php';
	$user = $_SESSION['user'];
	$level = $user['level'];
	ob_start();
	if($level != 'A')
		exit('UNAUTHORIZED');
	$pageRecords = 200;
	// Get sort parameters (field number and direction) and filters
	$sortBy = empty($_REQUEST['sort']) ? 1 : $_REQUEST['sort'];
	$orderBy = 'n'.$sortBy;
	$dir = getParametre('dir');
	if($dir != '' && $dir != 'asc') {
		$orderBy .= ' DESC';
		$reverseDir = 'asc';
	}
	else
		$reverseDir = 'desc';
	for($i = 1; $i <= 7; $i++) {
		if($sortBy == $i)
			$sortArrow[$i] = $reverseDir == 'desc' ? '&darr;' : '&uarr;';
		else
			$sortArrow[$i] = '';
	}
	//$result = sqlQuery("SELECT COUNT(*) FROM admin");
	$result = execute_sql("SELECT COUNT(*) FROM admin");
	//echo '$result : '.$result;
	if($row = mysqli_fetch_row($result))
		$totalCount = $row[0];
	else
		$totalCount = 0;
	if($totalCount > 0) {
		$totalPages = ceil($totalCount / $pageRecords);
		if($page = getParametre('page')) {
			if(!is_numeric($page) || $page < 1 || $page > $totalPages)
				$page = 1;
			// If a navigate button has been pressed
			switch(getParametre('navigate')) {
				case '|<':
					$page = 1;
					break;
				case '<<':
					$page -= 5;
					break;
				case '<':
					$page--;
					break;
				case '>':
					$page++;
					break;
				case '>>':
					$page += 5;
					break;
				case '>|':
					$page = $totalPages;
			}
		}
		else
			$page = 1;
		$backArrows = '';
		if($page > 1)
			$backArrows = '<input type="submit" name="navigate" value="|&lt;"/>&nbsp;';
		if($page > 5)
			$backArrows .= '<input type="submit" name="navigate" value="&lt&lt;"/>&nbsp;';
		if($page > 1)
			$backArrows .= '<input type="submit" name="navigate" value="&lt;"/>&nbsp;';
		$forwardArrows = '';
		if($page < $totalPages)
			$forwardArrows = '&nbsp;<input type="submit" name="navigate" value="&gt;"/>';
		if($page + 5 <= $totalPages)
			$forwardArrows .= '&nbsp;<input type="submit" name="navigate" value="&gt;&gt;"/>';
		if($page < $totalPages)
			$forwardArrows .= '&nbsp;<input type="submit" name="navigate" value="&gt;|"/>';
		$startRecord = ($page - 1) * $pageRecords;
		//$result = sqlQuery("SELECT id_membre,nombre AS n1,pseudo AS n2,email_direct AS n3,level AS n4 FROM admin ORDER BY $orderBy LIMIT $startRecord,$pageRecords");
		$result = execute_sql("SELECT id_membre,nombre AS n1,pseudo AS n2,email_direct AS n3,level AS n4 FROM admin ORDER BY $orderBy LIMIT $startRecord,$pageRecords");
		$lignes = mysqli_num_rows($result);
	}
	else
		$lignes = 0;
	$template = file_get_contents('../templates/elenco_venditori.html');
	$template = str_replace(
		array('$backArrows', '$page', '$totalPages', '$forwardArrows', '$sortBy', '$dir', '$reverseDir', '$sortArrow1', '$sortArrow2', '$sortArrow3', '$sortArrow4', '$sort'),
		array($backArrows, $page, $totalPages, $forwardArrows, $sortBy, $dir, $reverseDir, $sortArrow[1], $sortArrow[2], $sortArrow[3], $sortArrow[4], $sort),
		$template
	);
	if($lignes > 0) {
		// Note: If template does not contain the "listrow" id, it won't be parsed at all
		if(preg_match('!^(.+)(<tr id="listrow"[^>]*>.+?</tr>)(.+)$!is', $template, $matches)) {
			$template = $matches[1];
			while($row = mysqli_fetch_row($result)) {
				$l = count($row);
				for($i = 0; $i < $l; $i++)
					if($row[$i] == '' || is_null($row[$i]))
						$row[$i] = '&nbsp;';
				$template .= str_replace(
					array('$id', '$nombre', '$pseudo', '$email', '$level'),
					array($row[0], $row[1], $row[2], $row[3], $row[4]),
					$matches[2]
				);
			}
			$template .= $matches[3];
		}
	}
	elseif(preg_match('!^(.+)<tr id="pageselector"[^>]*>.+</tr>.+<tr id="listrow"[^>]*>.+</tr>(.+)$!isU', $template, $matches))
		$template = $matches[1].$matches[3];
	echo $template;
?>