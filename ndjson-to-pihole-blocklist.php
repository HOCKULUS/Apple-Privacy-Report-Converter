<?php
if (isset($_FILES['ndjson_file']) && $_FILES['ndjson_file']['error'] == 0) {
    $timestamp = date('D, d M Y, H:i T');
    $file = $_FILES['ndjson_file']['tmp_name'];
    
    $data = [];
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $json = json_decode($line, true);
            if (isset($json['timeStamp']) && isset($json['initiatedType']) && isset($json['context']) && isset($json['domain']) && isset($json['contextVerificationType']) && isset($json['type']) && isset($json['domainType']) && isset($json['firstTimeStamp']) && isset($json['bundleID']) && isset($json['domainOwner']) && isset($json['hits']) && isset($json['domainClassification'])) {
                $data[] = [
                    $json['bundleID'],
                    $json['domain']
                ];
            }
        }
        fclose($handle);
    }
    
    // Sort data by bundleID
    usort($data, function($a, $b) {
        return strcmp($a[0], $b[0]);
    });
    
    // Output PiHole blocklist
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename=blocklist.txt;');
  echo
"# Based on: https://github.com/HOCKULUS/Apple-Privacy-Report-Converter
# Title: Apple-Privacy-Report-BlockList
# Last modified: ".$timestamp."
# Creator: HOCKULUS
";  
  foreach ($data as $key => $fields) {
        if ($key == 0 || $fields[0] !== $data[$key-1][0]) {
            echo "\n# Bundle ID: {$fields[0]}\n";
        }
        echo "0.0.0.0 {$fields[1]}\n";
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>NDJSON zu PiHole Blocklist Konverter</title>
    </head>
    <body>
        <h1>NDJSON zu PiHole Blocklist Konverter</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="ndjson_file">
            <br>
            <input type="submit" name="submit" value="Konvertieren">
        </form>
    </body>
</html>
