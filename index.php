<?php
    include "encryption.php";
    error_reporting(0);
?>


<html lang="en">
<head>
  <script src="https://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="script.js"></script>
  <link rel="stylesheet" href="styles.css">
    <!-- Basic Page Needs
  ================================================== -->
    <meta charset="utf-8">
    <title>KRIPTOGRAFI</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
  ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
  ================================================== -->

    <!--[if lt IE 9]>
		<script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<body>

    <div class="container">
        <div class="flat-form">
            <ul class="tabs">
                <li>
                    <a href="#vigenere" class="active">Vigenere</a>
                </li>
                <li>
                    <a href="#playfair">Playfair</a>
                </li>
                <li>
                    <a href="#superE">Super Encryption</a>
                </li>
            </ul>
            <div id="vigenere" class="form-action show">
                <h1>Vigenere Cipher</h1>
                <p>
                    Sandi Vigenère adalah salah satu penyandian teks alfabet dengan menggunakan sandi Caesar Cipher akan tetapi alfabet yang dijadikan sebagai kata kuncinya. 
                </p>
                <form action="#vigenere" method="POST">
                    <ul>
                        <li>
                            <input type="text" placeholder="Message" name="message" value="<?php if(isset($_POST['message'])){echo $_POST['message'];} ?>" />
                        </li>
                        <li>
                            <input type="text" placeholder="Key" name="key" value="<?php if(isset($_POST['key'])){echo $_POST['key'];} ?>" />
                        </li>
                        <li>
                            <input type="submit" name="v_encrypt" value="Vigenere Encrypt" class="button" />
                            <input type="submit" name="v_decrypt" value="Vigenere Decrypt" class="button" />
                        </li>
                        <?php 
                            if ((isset($_POST['v_encrypt']) || isset($_POST['v_decrypt'])) && ($_POST['message'] && $_POST['key'])!=""){ 
                                $text = $_POST['message'];
                                $key = $_POST['key'];
                                if (isset($_POST['v_encrypt'])){
                                    $result = encrypt($text,$key);
                                }else if(isset($_POST['v_decrypt'])){
                                    $result = decrypt($text,$key);
                                }
                                echo "<li><p style=\"margin-top: 50px;\">Hasil Enkripsi : </p></li>";
                                echo "<li> <input type=\"text\" name=\"hasil\" value=\"".$result."\"/> </li>";
                            }
                        ?>
                    </ul>
                </form>

            </div>

            <!--/#login.form-action-->
            <div id="playfair" class="form-action hide">
                <h1>Playfair Cipher</h1>
                <p>
                    Playfair cipher atau bisa juga disebut Playfair square adalah teknik enkripsi simetrik yang termasuk dalam sistem substitusi digraph.
                </p>
                <form action="#playfair" method="POST">
                    <ul> 
                        <li>
                            <input type="text" placeholder="Message" name="message" value="<?php if(isset($_POST['message'])){echo $_POST['message'];} ?>" />
                        </li>
                        <li>
                            <input type="text" placeholder="Key" name="key" value="<?php if(isset($_POST['key'])){echo $_POST['key'];} ?>" />
                        </li>
                        <li>
                            <input type="submit" value="Playfair Encrypt" class="button" name="p_encrypt"/>
                            <input type="submit" value="Playfair Decrypt" class="button" name="p_decrypt"/>
                        </li>
                        <?php 
                            if ((isset($_POST['p_encrypt']) || isset($_POST['p_decrypt'])) && ($_POST['message'] && $_POST['key'])!=""){ 
                                $text = $_POST['message'];
                                $key = $_POST['key'];
                                $aray = createTable($key);
                                if (isset($_POST['p_encrypt'])){
                                    $result = p_encrypt($text,$key);
                                }else if(isset($_POST['p_decrypt'])){
                                    $result = p_decrypt($text,$key);
                                }

                                echo "<li><table>";
                                for ($i=0; $i<5; $i++) { 
                                    echo "<tr>";
                                    for ($j=0; $j<5; $j++) {
                                       echo "<td>".$aray[$i][$j]."</td>";
                                    }                                  
                                    echo "</tr>";
                                }
                                
                                echo "</table></li> ";
                                echo "<li><p style=\"margin-top: 10px;\">Hasil Enkripsi : </p></li>";
                                echo "<li> <input type=\"text\" name=\"hasil\" value=\"".$result."\"/> </li>";
                            }
                        ?>
                    </ul>
                </form>
            </div>
            <!--/#register.form-action-->
            <div id="superE" class="form-action hide">
                <h1>Super Encryption</h1>
                <p>
                    Super enkripsi di program ini adalah gabungan dari vigenere cipher dan playfair cipher.
                </p>
                <form  action="#superE" method="POST">
                    <ul>
                        <li>
                            <input type="text" placeholder="Message" name="message" value="<?php if(isset($_POST['message'])){echo $_POST['message'];} ?>" />
                        </li>
                        <li>
                            <input type="text" placeholder="Key" name="key" value="<?php if(isset($_POST['key'])){echo $_POST['key'];} ?>" />
                        </li>
                        <li>
                            <input type="submit" value="Super Encrypt" class="button" name="s_encrypt"/>
                            <input type="submit" value="Super Decrypt" class="button" name="s_decrypt"/>
                        </li>
                        <?php 
                            if ((isset($_POST['s_encrypt']) || isset($_POST['s_decrypt'])) && ($_POST['message'] && $_POST['key'])!=""){ 
                                $text = $_POST['message'];
                                $key = $_POST['key'];
                                $aray = createTable($key);
                                if (isset($_POST['s_encrypt'])){
                                    $result = p_encrypt(encrypt($text,$key),$key);
                                }else if(isset($_POST['s_decrypt'])){
                                    $result = decrypt(p_decrypt($text,$key),$key);
                                }

                                echo "<li><table>";
                                for ($i=0; $i<5; $i++) { 
                                    echo "<tr>";
                                    for ($j=0; $j<5; $j++) {
                                       echo "<td>".$aray[$i][$j]."</td>";
                                    }                                  
                                    echo "</tr>";
                                }
                                
                                echo "</table></li> ";
                                echo "<li><p style=\"margin-top: 10px;\">Hasil Enkripsi : </p></li>";
                                echo "<li> <input type=\"text\" name=\"hasil\" value=\"".$result."\"/> </li>";
                            }
                        ?>
                    </ul>
                </form>
            </div>
            <!--/#register.form-action-->
        </div>
    </div>
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
</body>
</html>
