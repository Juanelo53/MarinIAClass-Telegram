<?php
/**
 * Author: Juanelo
 */

// Inicio de la CLase
class MarinIA{
  const VERSION = '0.0.1';
  private $botToken;
  private $metodo;
  private $datas;
  public $api_url;


  /// Peticion al bot token
  /**
   * Coloca el Token de tu bot
   * Ejemplo:
   * $bot = new MarinIA('TOKEN');
   * @param mixed $botToken
   */
  public function __construct($botToken){
    $this->botToken = $botToken;
    $this->api_url = "https://api.telegram.org/bot" . $this->botToken . "/";
  }

  /**
   * Envia cualquier mensaje, editar/mensaje/video/documento/etc.. 
   * Ejemplo:
   * enviar('sendMessage', [
   * "chat_id" => 123456,
   * "text" => "Hola, ¿cómo estás?, Soy Un bot creado desde la libreria de MarinIA!",
   * 'reply_markup => json_encode('inline_keyboard', [
   * [
   *   ['text' => "Hola soy un boton!", 'url' => 'https://t.me/MarinIA_bot']
   * ]
   *     ])
   *  ]);
   * $res = $marinBot->enviar($method, $datas);
   * @param mixed $method
   * @param mixed $datas
   * @return string|array
   */
public function enviar($metodo, $datas) {
    // Estos parametros son por defecto del bot en parse_mode usted puede canviarlo a markdown o dejarlo en html :)
  $update = $this->getUpdates();
  $message_id = $update->message->message_id;
  $datas['reply_to_message_id'] = $message_id;
  $datas['parse_mode'] = 'html';
  
  $this->metodo = $metodo;
  $this->datas = $datas;
  $this->api_url = "https://api.telegram.org/bot".$this->botToken."/".$this->metodo;

  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$this->api_url);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$this->datas);
  $res = curl_exec($ch);

  if(curl_error($ch)){
    var_dump(curl_error($ch));
  }else{
    return $res;
  }
    return true;
}

// Obtener las varaibles del bot
  /**
   * Retorna las actualizaciones del bot en formato Json
   * $updates = $bot->getUpdates();
   * $chat_id = $updates->message->chat->id
   * @return mixed
   */
  public function getUpdates() {
    $response = file_get_contents("php://input");
    return json_decode($response, false);
  }


  // Conexion a la base de datos
  /**
   * Esta función toma cuatro argumentos: el nombre de host de la base de datos, el nombre de usuario, la contraseña y el nombre de la base de datos. 
   * Luego, intenta conectarse a la base de datos usando esta información y devuelve un objeto de conexión si la conexión es exitosa.
   * Si la conexión falla, se imprime un mensaje de error y se termina la ejecución del script.
   * Para usar esta función, simplemente pase la información necesaria como argumentos al llamar a la función, como en el siguiente ejemplo:
   * $conn = $MarinIA->connect("localhost", "userdb", "password", "my_db");
   * @param mixed $host
   * @param mixed $username
   * @param mixed $password
   * @param mixed $dbname
   * @return bool|mysqli
   */
  public function connect($host, $username, $password, $dbname) {
    $conn = mysqli_connect($host, $username, $password, $dbname);
    if (!$conn) {
      die("Error de conexión: " . mysqli_connect_error());
    }
    return $conn;
  }


} // Cierre de la clase

  /**
   * Ejemplo de uso:
   * 
   * $nombre = "KEYDEMIBOT";
   * 
   * $key = GenerarKeys($nombre);
   * 
   * la variable $key contendrá algo como "KEYDEMIBOT-SDFS-EFSE-FSEF-SEF6-SE4F-35SE-F1AA-W6F4-AW"
   * 
   * @param mixed $nombre
   * @return string
   */
  function GenerarKeys($nombre) {
    // generar una clave aleatoria de 12 dígitos
  $key = "";
  for ($i = 0; $i < 12; $i++) {
    $key .= chr(rand(48, 90));
  }

  // eliminar cualquier carácter no válido
  $key = preg_replace("/[^A-Za-z0-9]/", "", $key);

  // asegurarse de que la clave tenga exactamente 12 dígitos
  $key = str_pad($key, 12, "0", STR_PAD_RIGHT);

  // dividir la clave en grupos de 4 dígitos separados por guión
  $key = substr($key, 0, 4) . "-" . substr($key, 4, 4) . "-" . substr($key, 8);

  // agregar el nombre y un guión al inicio y al final
  $key = $nombre . "-" . $key . "";

  return $key;
  }
  

?>
