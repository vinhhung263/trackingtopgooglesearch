
<form action="">
  <label for="keyword">Keyword: </label>
  <input type="text" id="keyword" name="keyword" value="<?=$_GET['keyword']?>"><br><br>
  <label for="domain">Domain: </label>
  <input type="text" id="domain" name="domain" value="<?=$_GET['domain']?>"><br><br>
  <label for="topsearch">Top Search: </label>
  <input type="text" id="topsearch" name="topsearch" value="<?=$_GET['topsearch']?>"><br><br>
  <input type="submit" value="Submit">
</form>


<?php
$starttime = microtime(true);
require_once("simple_html_dom.php");

if(!empty($_GET['keyword']) && !empty($_GET['domain'])){

//Input
$input_keyword = $_GET['keyword'];
$input_domain = $_GET['domain'];
$input_topsearch = ($_GET['topsearch'] == '') ? 50 : $_GET['topsearch'] ;
echo '-------------------------------------------<br>';



$index_rank = 0;
$output_rank = 0;
$search_url = 'https://www.google.co.in/search?q='.urlencode($input_keyword).'&ie=utf-8&oe=utf-8&start=';

echo '<strong> Tool Tracking Top Google Search By Domain </strong><br>';
echo '-------------------------------------------<br>';
echo 'Keyword: ' . $input_keyword . "<br>";
echo 'Domain: ' . $input_domain . "<br>";
echo 'Top search: ' . $input_topsearch . "<br>";


for($i = 0;$i<($input_topsearch/10);$i++){
    //Get Data from each page
    $htmlData = file_get_html($search_url . ($i*10));
    //Check all link of each page
    foreach($htmlData->find('a') as $element){
        $linkTopSearch = $element->href;
        if (strpos($linkTopSearch, 'url?') !== false) {
            if(isset($element->children(0)->innertext)){
                $innertext = $element->children(0)->innertext;
                if (strpos($innertext, '<div') !== false) {
                    $index_rank = $index_rank + 1;
                    //echo "Rank ".$index_rank ." <br>";
                    //echo $innertext . '<br>';
                    //echo $linkTopSearch . '<br><br><br>';

                    //Link that we find
                    if (strpos($linkTopSearch, $input_domain)!== false) {
                        $output_rank = $index_rank;
                        echo 'Result: Top ' . $output_rank . "<br>";
                        $endtime = microtime(true);
                        echo 'Time tracking: ' . round($endtime - $starttime,2) . ' second(s)';
                        exit;
                    }

                }
            }
        }
    }
}
//Out of Top Search
echo 'Result: Out of Top Search<br>';
$endtime = microtime(true);
echo 'Time tracking: ' . round($endtime - $starttime,2) . ' second(s)';

exit;

}





?>