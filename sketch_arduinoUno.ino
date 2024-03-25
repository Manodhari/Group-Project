#include <SoftwareSerial.h>
#include <SPI.h>
#include <MFRC522.h>
#include <Servo.h>

SoftwareSerial S(5, 6);  //(RX,TX)
#define RST_PIN 9
#define SS_PIN 10
const int irSensorPin = 7;

MFRC522 mfrc522(SS_PIN, RST_PIN);
Servo servoMotor;

bool isSlot1Available = true;
bool isSlot2Available = true;
bool isSlot3Available = true;
bool isSlot4Available = true;
bool isSlot5Available = true;

void setup() {
  Serial.begin(9600);
  S.begin(9600);


  SPI.begin();
  mfrc522.PCD_Init();
  servoMotor.attach(3);
  servoMotor.write(0);
  pinMode(irSensorPin, INPUT);
  delay(4);
  Serial.println(F("Scan PICC to see UID..."));
}

void loop() {

  if (S.available() > 0) {
    String message = S.readStringUntil('\n');
    message.trim();

    String slotNumStr = message.substring(0, 1);
    String slotAVB = message.substring(1);
    int slotNum = slotNumStr.toInt();

    bool sensorStatus = (slotAVB == "AVAILABLE") ? true : false;

    switch (slotNum) {
      case 1:
        isSlot1Available = sensorStatus;
        Serial.print("Sensor 1: ");
        Serial.println(isSlot1Available);
        break;
      case 2:
        isSlot2Available = sensorStatus;
        Serial.print("Sensor 2: ");
        Serial.println(isSlot2Available);
        break;
      case 3:
        isSlot3Available = sensorStatus;
        Serial.print("Sensor 3: ");
        Serial.println(isSlot3Available);
        break;
      case 4:
        isSlot4Available = sensorStatus;
        Serial.print("Sensor 4: ");
        Serial.println(isSlot4Available);
        break;
      case 5:
        isSlot5Available = sensorStatus;
        Serial.print("Sensor 5: ");
        Serial.println(isSlot5Available);
        break;
      default:
        // Invalid sensor number
        break;
    }
  }


  if (!mfrc522.PICC_IsNewCardPresent()) {
    return;
  }

  if (!mfrc522.PICC_ReadCardSerial()) {
    return;
  }

  if (isSlot1Available || isSlot2Available || isSlot3Available || isSlot4Available || isSlot5Available) {
    Serial.print(F("Card UID: "));
    String uidString = "";
    for (byte i = 0; i < mfrc522.uid.size; i++) {
      uidString += (mfrc522.uid.uidByte[i] < 0x10 ? " 0" : " ");
      uidString += (String(mfrc522.uid.uidByte[i], HEX));
    }
    Serial.println(uidString);
    delay(2000);
    S.println(uidString);
    // open gate...
    servoMotor.write(90);
    // wait until vehicle passes...
    //------------------------------------------------------
    waitForVehicle();
    // delay(5000);
    //------------------------------------------------------
    // close gate...
    servoMotor.write(0);
  }
  delay(1000);
  // check for another rfid card...
}

void waitForVehicle() {
  // wait until the vehicle comes...
  while (digitalRead(irSensorPin)) {
    delay(100);
  }
  Serial.println("Vehicle detected!");
  // wait until the vehicle goes...
  while (!digitalRead(irSensorPin)) {
    delay(100);
  }
  Serial.println("Vehicle passed!");
  delay(3000);
}
