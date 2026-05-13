<?php
/**
 * @var string $inputData
 * @var string $inputFormat
 * @var string $outputFormat
 * @var string $result
 */
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Konwerter Danych</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; padding-top: 50px; background-color: #f0f0f0; }
        .converter-container {
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 850px;
        }
        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        select {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #777;
            border-radius: 4px;
        }
        textarea, .output-box {
            width: 100%;
            height: 350px;
            border: 1px solid #777;
            border-radius: 4px;
            padding: 10px;
            box-sizing: border-box;
            font-family: monospace;
            font-size: 14px;
            margin: 0;
        }
        .output-box {
            background-color: #fff;
            white-space: pre-wrap;
            overflow-y: auto;
        }
        .convert-btn {
            width: 100%;
            padding: 10px;
            cursor: pointer;
            border: 1px solid #777;
            border-radius: 4px;
            background-color: #efefef;
            font-size: 16px;
        }
        .convert-btn:hover { background-color: #e0e0e0; }
    </style>
</head>
<body>

<div class="converter-container">
    <form method="POST">
        <div class="grid-container">
            <!-- lewa kolumna: wejście -->
            <div class="column">
                <select name="input_format">
                    <?php foreach (['csv', 'ssv', 'tsv', 'json', 'yaml'] as $f): ?>
                        <option value="<?= $f ?>" <?= $inputFormat === $f ? 'selected' : '' ?>><?= $f ?></option>
                    <?php endforeach; ?>
                </select>
                <textarea name="input_data"><?= htmlspecialchars($inputData) ?></textarea>
            </div>

            <!-- prawa kolumna: wyjście -->
            <div class="column">
                <select name="output_format">
                    <?php foreach (['csv', 'ssv', 'tsv', 'json', 'yaml'] as $f): ?>
                        <option value="<?= $f ?>" <?= $outputFormat === $f ? 'selected' : '' ?>><?= $f ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="output-box"><?= htmlspecialchars($result) ?></div>
            </div>
        </div>

        <button type="submit" class="convert-btn">Convert</button>
    </form>
</div>

</body>
</html>