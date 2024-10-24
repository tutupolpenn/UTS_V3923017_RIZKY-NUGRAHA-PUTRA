<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enkripsi & Dekripsi - Caesar dan Vigenere Cipher</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e0f7fa; /* Warna biru lembut seperti air laut */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            border: 2px solid #00acc1;
            position: relative;
        }

        h1 {
            text-align: center;
            color: #006064;
            text-shadow: 1px 1px 3px rgba(0, 150, 136, 0.5);
            font-size: 2.2em;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #004d40;
            margin-bottom: 5px;
        }

        textarea, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #80deea;
            border-radius: 8px;
            font-size: 16px;
            background-color: #e0f7fa;
            color: #004d40;
        }

        textarea {
            height: 100px;
            resize: none; /* Mencegah pengguna mengubah ukuran textarea */
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .btn {
            flex: 1;
            padding: 12px 0;
            background-color: #00838f;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #006064;
        }

        .result {
            background-color: #e0f2f1;
            padding: 15px;
            margin-top: 25px;
            border-radius: 10px;
            border: 1px solid #80cbc4;
            color: #004d40;
        }

        .result strong {
            font-size: 18px;
            color: #00796b;
        }

        /* Efek Dekorasi Aquatic */
        .container:before {
            content: '';
            position: absolute;
            top: -30px;
            left: -30px;
            width: 80px;
            height: 80px;
            background: radial-gradient(circle, rgba(0,150,136,0.2), rgba(0,150,136,0.05));
            border-radius: 50%;
            z-index: -1;
        }

        .container:after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: radial-gradient(circle, rgba(0,150,136,0.2), rgba(0,150,136,0.05));
            border-radius: 50%;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Enkripsi & Dekripsi - Caesar dan Vigenere Cipher</h1>
        <form method="POST" action="">
            <label for="plain_text">Plain Text:</label>
            <textarea name="plain_text" id="plain_text" placeholder="Masukkan teks yang akan dienkripsi..." required></textarea>

            <label for="caesar_shift">Kunci Numerik (Caesar Cipher):</label>
            <input type="number" name="caesar_shift" id="caesar_shift" value="" required>

            <label for="vigenere_key">Kunci Teks (Vigenere Cipher):</label>
            <input type="text" name="vigenere_key" id="vigenere_key" value="" required>

            <div class="button-container">
                <button class="btn" type="submit" name="encrypt">Enkripsi</button>
                <button class="btn" type="submit" name="decrypt">Dekripsi</button>
            </div>
        </form>

        <?php
        // Fungsi Caesar Cipher dan Vigenere Cipher (tidak diubah)
        function caesar_encrypt($plain_text, $shift) {
            $encrypted = '';
            $shift = $shift % 26;
            for ($i = 0; $i < strlen($plain_text); $i++) {
                $char = $plain_text[$i];
                if (ctype_alpha($char)) {
                    $is_upper = ctype_upper($char);
                    $ascii_offset = $is_upper ? 65 : 97;
                    $new_char = chr(($ascii_offset + (ord($char) - $ascii_offset + $shift) % 26));
                    $encrypted .= $new_char;
                } else {
                    $encrypted .= $char;
                }
            }
            return $encrypted;
        }

        function caesar_decrypt($cipher_text, $shift) {
            $decrypted = '';
            $shift = $shift % 26;
            for ($i = 0; $i < strlen($cipher_text); $i++) {
                $char = $cipher_text[$i];
                if (ctype_alpha($char)) {
                    $is_upper = ctype_upper($char);
                    $ascii_offset = $is_upper ? 65 : 97;
                    $new_char = chr(($ascii_offset + (ord($char) - $ascii_offset - $shift + 26) % 26));
                    $decrypted .= $new_char;
                } else {
                    $decrypted .= $char;
                }
            }
            return $decrypted;
        }

        function vigenere_encrypt($plain_text, $key) {
            $encrypted = '';
            $key = strtoupper($key);
            $key_length = strlen($key);
            $j = 0;
            for ($i = 0; $i < strlen($plain_text); $i++) {
                $char = $plain_text[$i];
                if (ctype_alpha($char)) {
                    $is_upper = ctype_upper($char);
                    $ascii_offset = $is_upper ? 65 : 97;
                    $key_shift = ord($key[$j % $key_length]) - 65;
                    $new_char = chr(($ascii_offset + (ord($char) - $ascii_offset + $key_shift) % 26));
                    $encrypted .= $new_char;
                    $j++;
                } else {
                    $encrypted .= $char;
                }
            }
            return $encrypted;
        }

        function vigenere_decrypt($cipher_text, $key) {
            $decrypted = '';
            $key = strtoupper($key);
            $key_length = strlen($key);
            $j = 0;
            for ($i = 0; $i < strlen($cipher_text); $i++) {
                $char = $cipher_text[$i];
                if (ctype_alpha($char)) {
                    $is_upper = ctype_upper($char);
                    $ascii_offset = $is_upper ? 65 : 97;
                    $key_shift = ord($key[$j % $key_length]) - 65;
                    $new_char = chr(($ascii_offset + (ord($char) - $ascii_offset - $key_shift + 26) % 26));
                    $decrypted .= $new_char;
                    $j++;
                } else {
                    $decrypted .= $char;
                }
            }
            return $decrypted;
        }

        function encrypt_combination($plain_text, $caesar_shift, $vigenere_key) {
            $caesar_encrypted = caesar_encrypt($plain_text, $caesar_shift);
            return vigenere_encrypt($caesar_encrypted, $vigenere_key);
        }

        function decrypt_combination($cipher_text, $caesar_shift, $vigenere_key) {
            $vigenere_decrypted = vigenere_decrypt($cipher_text, $vigenere_key);
            return caesar_decrypt($vigenere_decrypted, $caesar_shift);
        }

        // Proses Form
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $plain_text = $_POST['plain_text'];
            $caesar_shift = intval($_POST['caesar_shift']);
            $vigenere_key = $_POST['vigenere_key'];

            if (isset($_POST['encrypt'])) {
                $cipher_text = encrypt_combination($plain_text, $caesar_shift, $vigenere_key);
                echo "<div class='result'><strong>Hasil Enkripsi:</strong><br>$cipher_text</div>";
            }

            if (isset($_POST['decrypt'])) {
                $decrypted_text = decrypt_combination($plain_text, $caesar_shift, $vigenere_key);
                echo "<div class='result'><strong>Hasil Dekripsi:</strong><br>$decrypted_text</div>";
            }
        }
        ?>
    </div>
</body>
</html>
