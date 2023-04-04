<?php

if (isset($_FILES['ndjson_file']) && $_FILES['ndjson_file']['error'] == 0) {
    $file = $_FILES['ndjson_file']['tmp_name'];
    
    $data = [];
    $handle = fopen($file, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $json = json_decode($line, true);
            if (isset($json['timeStamp']) && isset($json['initiatedType']) && isset($json['context']) && isset($json['domain']) && isset($json['contextVerificationType']) && isset($json['type']) && isset($json['domainType']) && isset($json['firstTimeStamp']) && isset($json['bundleID']) && isset($json['domainOwner']) && isset($json['hits']) && isset($json['domainClassification'])) {
                $data[] = [
                    $json['timeStamp'],
                    $json['initiatedType'],
                    $json['context'],
                    $json['domain'],
                    $json['contextVerificationType'],
                    $json['type'],
                    $json['domainType'],
                    $json['firstTimeStamp'],
                    $json['bundleID'],
                    $json['domainOwner'],
                    $json['hits'],
                    $json['domainClassification']
                ];
            }
        }
        fclose($handle);
    }
    
    // Output CSV
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename=ndjson.csv;');
    $fp = fopen('php://output', 'w');
    fputcsv($fp, ['Timestamp', 'Initiated Type', 'Context', 'Domain', 'Context Verification Type', 'Type', 'Domain Type', 'First Timestamp', 'Bundle ID', 'Domain Owner', 'Hits', 'Domain Classification']);
    foreach ($data as $fields) {
        fputcsv($fp, $fields);
    }
    fclose($fp);
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="UTF-8">
        <title>NDJSON zu CSV Konverter</title>
    </head>
    <body>
        <h1>NDJSON zu CSV Konverter</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
            <input type="file" name="ndjson_file">
            <br>
            <input type="submit" name="submit" value="Konvertieren">
        </form>
    </body>
</html>
