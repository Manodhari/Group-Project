#include <ESP8266WiFi.h>
#include <FirebaseESP8266.h>
#include <SoftwareSerial.h>

#define FIREBASE_HOST "https://parkingsystem-46aec-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "AIzaSyBdmwjLd21IhrOJN6ngHbw5BRSpun_MUK0"
#define WIFI_SSID "..."
#define WIFI_PASSWORD "..."

//REGISTERED USERS VARIABLES
String isUser1Started = "NO";
String isUser2Started = "NO";
String isUser3Started = "NO";
String isUser4Started = "NO";

#define IR_SENSOR_PIN_1 D2
#define IR_SENSOR_PIN_2 D0
#define IR_SENSOR_PIN_3 D7
#define IR_SENSOR_PIN_4 D3
#define IR_SENSOR_PIN_5 D1

FirebaseData firebaseData;
SoftwareSerial s(D6, D5);  //(RX,TX)
int lastAssignedId = 0;

bool prevSensorStatus1 = false;
bool prevSensorStatus2 = false;
bool prevSensorStatus3 = false;
bool prevSensorStatus4 = false;
bool prevSensorStatus5 = false;

void connectWiFi() {
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  Serial.print("Connecting to WiFi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println();
  Serial.println("Connected to WiFi!");
}

void updateFirebaseForSensor(int sensorNumber, bool sensorStatus) {
  String statusString = sensorStatus ? "NOTAVAILABLE" : "AVAILABLE";
  String path = "/SLOT " + String(sensorNumber) + " Status";
  Firebase.setString(firebaseData, path.c_str(), statusString);
  Serial.println("IR Sensor " + String(sensorNumber) + " status sent to Firebase: " + statusString);
  s.println(String(sensorNumber) + statusString);
}

void sendUIDToFirebase(int id) {
  String path = "/User_No_" + String(id);
  String statusPath = path + "/Status";

  switch (id) {
    case 1:
      isUser1Started = isUser1Started.equals("STARTED") ? "ENDED" : "STARTED";
      Firebase.setString(firebaseData, statusPath, isUser1Started);
      break;
    case 2:
      isUser2Started = isUser2Started.equals("STARTED") ? "ENDED" : "STARTED";
      Firebase.setString(firebaseData, statusPath, isUser2Started);
      break;
    case 3:
      isUser3Started = isUser3Started.equals("STARTED") ? "ENDED" : "STARTED";
      Firebase.setString(firebaseData, statusPath, isUser3Started);
      break;
    case 4:
      isUser4Started = isUser4Started.equals("STARTED") ? "ENDED" : "STARTED";
      Firebase.setString(firebaseData, statusPath, isUser4Started);
      break;
    default:
      // Serial.println("User not registered");
      break;
  }
}

void setup() {
  Serial.begin(9600);
  s.begin(9600);

  connectWiFi();

  // Initialize Firebase
  Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);

  // Set pins for IR sensors as input
  pinMode(IR_SENSOR_PIN_1, INPUT);
  pinMode(IR_SENSOR_PIN_2, INPUT);
  pinMode(IR_SENSOR_PIN_3, INPUT);
  pinMode(IR_SENSOR_PIN_4, INPUT);
  pinMode(IR_SENSOR_PIN_5, INPUT);
}

void loop() {

  if (s.available() > 0) {
    String UID = s.readStringUntil('\n');
    UID.trim();
    Serial.print("Received UID: ");
    Serial.println(UID);
    int ID = 0;
    if (UID == "14 7e 71 2b") {
      ID = 1;
    } else if (UID == "97 f0 b2 7b") {
      ID = 2;
    } else if (UID == "d7 8a bf 7b") {
      ID = 3;
    } else if (UID == "c9 5d c4 b2") {
      ID = 4;
    } else {
      Serial.println("USER NOT REGISTERED");
    }
    sendUIDToFirebase(ID);
  }

  bool sensorStatus1 = digitalRead(IR_SENSOR_PIN_1);
  bool sensorStatus2 = digitalRead(IR_SENSOR_PIN_2);
  bool sensorStatus3 = digitalRead(IR_SENSOR_PIN_3);
  bool sensorStatus4 = digitalRead(IR_SENSOR_PIN_4);
  bool sensorStatus5 = digitalRead(IR_SENSOR_PIN_5);

  if (sensorStatus1 != prevSensorStatus1) {
    updateFirebaseForSensor(1, !sensorStatus1);
    prevSensorStatus1 = sensorStatus1;
  }

  if (sensorStatus2 != prevSensorStatus2) {
    updateFirebaseForSensor(2, !sensorStatus2);
    prevSensorStatus2 = sensorStatus2;
  }

  if (sensorStatus3 != prevSensorStatus3) {
    updateFirebaseForSensor(3, !sensorStatus3);
    prevSensorStatus3 = sensorStatus3;
  }

  if (sensorStatus4 != prevSensorStatus4) {
    updateFirebaseForSensor(4, !sensorStatus4);
    prevSensorStatus4 = sensorStatus4;
  }

  if (sensorStatus5 != prevSensorStatus5) {
    updateFirebaseForSensor(5, !sensorStatus5);
    prevSensorStatus5 = sensorStatus5;
  }
}