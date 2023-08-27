#include <WiFi.h>
#include <HTTPClient.h>
#include <MFRC522.h>
#include <SPI.h>
#include <LiquidCrystal_I2C.h>

#define SS_PIN 5
#define RST_PIN 13
#define buzzer_pin 2  
#define relay_pin 4 

// WiFi Configuration
char ssid[] = "Asoi Tabang";
char pass[] = "lahgalaksurang";

// MySQL Server Configuration
const String serverAddress = "http://192.168.251.237"; 
const int serverPort = 3306; 
LiquidCrystal_I2C lcd(0x27, 16, 2);
MFRC522 mfrc522(SS_PIN, RST_PIN);
HTTPClient http;

void setup() {
lcd.init();
lcd.backlight();
lcd.clear();
pinMode(buzzer_pin, OUTPUT);
pinMode(relay_pin, OUTPUT);
digitalWrite(buzzer_pin, LOW);
digitalWrite(relay_pin, HIGH);
  
  Serial.begin(115200);
  SPI.begin();
  mfrc522.PCD_Init();
  delay(2000);
  WiFi.begin(ssid, pass);

  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
    lcd.setCursor(4,0);
    lcd.print("Loading");
  }

  Serial.println("Connected to WiFi");
}

void loop() {
  lcd.clear();
  lcd.setCursor(4,0);
  lcd.print("STANDBY");
  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  String uid = "";
  for (byte i = 0; i < mfrc522.uid.size; i++) {
    uid += String(mfrc522.uid.uidByte[i] < 0x10 ? "0" : "");
    uid += String(mfrc522.uid.uidByte[i], HEX);
  }

  Serial.print("UID: ");
  Serial.println(uid);

  ////check UID/////
  String queryUrl = serverAddress + "/Skripsi/check_uid_exist.php?uid=" + uid;
  http.begin(queryUrl);
  int httpResponseCode = http.GET();
  if (httpResponseCode == 200) {
    String response = http.getString();
    Serial.print("Response: ");
    Serial.println(response);

    if (response == "exist") {
      // UID exists
      String logUrl = serverAddress + "/Skripsi/log_uid.php?uid=" + uid;
      http.begin(logUrl);
      int logHttpResponseCode = http.GET();
      if (logHttpResponseCode == 200) {
        String logResponse = http.getString();
        Serial.print("Access Log Response: ");
        Serial.println(logResponse);
      } else {
        Serial.print("Error logging access: ");
        Serial.println(logHttpResponseCode);
        lcd.clear();
   lcd.setCursor(0,0);
   lcd.print("DATABASE ERROR");
      }
      http.end();

 lcd.clear();
  lcd.setCursor(3,0);
  lcd.print("RFID VALID");
      digitalWrite(relay_pin, LOW);
      digitalWrite(buzzer_pin, HIGH);
      delay(300);
      digitalWrite(buzzer_pin, LOW);
      delay(150);
      digitalWrite(buzzer_pin, HIGH);
      delay(200);
      digitalWrite(buzzer_pin, LOW);
      delay(5000);

digitalWrite(relay_pin, HIGH);
      
    } else {
   lcd.clear();
  lcd.setCursor(0,0);
  lcd.print("RFID TIDAK VALID");
      digitalWrite(relay_pin, HIGH);
      digitalWrite(buzzer_pin, HIGH);
      delay(1000);
      digitalWrite(buzzer_pin, LOW);
      delay(700);

    }
  } else {
    Serial.print("Error checking UID existence: ");
    Serial.println(httpResponseCode);
    lcd.clear();
   lcd.setCursor(0,0);
  lcd.print("GAGAL TERHUBUNG");
  lcd.setCursor(0,1);
  lcd.print("DENGAN DATABASE");

    digitalWrite(relay_pin, HIGH);
    
    digitalWrite(buzzer_pin, HIGH);
    delay(700);
    digitalWrite(buzzer_pin, LOW);
    delay(300);
    digitalWrite(buzzer_pin, HIGH);
    delay(700);
    digitalWrite(buzzer_pin, LOW);
    delay(700);
  }

  http.end();
 
  delay(2000);
}
