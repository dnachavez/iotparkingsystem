#include <WiFiS3.h>
#include <ArduinoHttpClient.h>
#include <ArduinoJson.h>
#include <Servo.h>
#include <LCD_I2C.h>

const char* ssid = "";
const char* password = "";
String URL = "";
int port = 80;

WiFiClient wifi;
HttpClient client = HttpClient(wifi, URL, port);
String contentType = "application/json";

int gate;
const char* tollgateStatus;
const char* space1Status;
const char* space2Status;
const char* space3Status;
const char* space4Status;
int space1;
int space2;
int space3;
int space4;
int sen1 = 2;
int sen2 = 3;
int sen3 = 4;
int sen4 = 5;
int doorsen = 8;
int senval1, senval2, senval3, senval4, doorsenval;
int slot, parkingcount, space1count, space2count, space3count, space4count;

Servo servo;
LCD_I2C lcd(0x27, 16, 2);

void setup() {
    lcd.begin();
    lcd.backlight();
    servo.attach(8);
    servo.write(0);
    Serial.begin(115200);
    WiFi.begin(ssid, password);
    Serial.println("Connecting");
    while (WiFi.status() != WL_CONNECTED) {
        delay(500);
        Serial.print(".");
    }
    Serial.println("");
    Serial.print("Connected to WiFi network with IP Address: ");
    Serial.println(WiFi.localIP());
}

void loop() {
    if (WiFi.status() == WL_CONNECTED) {
        parse();
        printSpaceInfo();
        screen();
        tollgate();
        senfuntion();
        senalgo();
    } else {
        Serial.println("WiFi Disconnected");
    }
}

void parse() {
    client.get("/api/parking/status");
    int httpCode = client.responseStatusCode();
    
    if (httpCode > 0) {
        String JSON_Data = client.responseBody();
        DynamicJsonDocument doc(1024);
        DeserializationError error = deserializeJson(doc, JSON_Data);
        
        if (error) {
            Serial.print("Failed to parse JSON: ");
            Serial.println(error.c_str());
            return;
        }
        
        tollgateStatus = doc["tollgateStatus"];
        
        JsonObject space1Object = doc["parkingSpaces"][0];
        space1 = space1Object["parkingSpaceId"];
        space1Status = space1Object["parkingSpaceStatus"];
        
        JsonObject space2Object = doc["parkingSpaces"][1];
        space2 = space2Object["parkingSpaceId"];
        space2Status = space2Object["parkingSpaceStatus"];
        
        JsonObject space3Object = doc["parkingSpaces"][2];
        space3 = space3Object["parkingSpaceId"];
        space3Status = space3Object["parkingSpaceStatus"];
        
        JsonObject space4Object = doc["parkingSpaces"][3];
        space4 = space4Object["parkingSpaceId"];
        space4Status = space4Object["parkingSpaceStatus"];
    }
}

void tollgate() {
    gate = (strcasecmp(tollgateStatus, "open") == 0) ? 1 : 0;
    Serial.println(gate);
    if (gate == 1) {
        Serial.println("Tollgate is Open");
        servo.write(90);
    } else {
        servo.write(0);
        Serial.println("Tollgate is Close");
    }
}

void senfuntion() {
    senval1 = digitalRead(sen1);
    senval2 = digitalRead(sen2);
    senval3 = digitalRead(sen3);
    senval4 = digitalRead(sen4);
    doorsenval = digitalRead(doorsen);
}

void senalgo() {
    if (senval1 == LOW) {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"1\",\"parkingSpaceStatus\":\"0\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    } else {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"1\",\"parkingSpaceStatus\":\"1\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    }

    if (senval2 == LOW) {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"2\",\"parkingSpaceStatus\":\"0\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    } else {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"2\",\"parkingSpaceStatus\":\"1\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    }

    if (senval3 == LOW) {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"3\",\"parkingSpaceStatus\":\"0\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    } else {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"3\",\"parkingSpaceStatus\":\"1\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    }

    if (senval4 == LOW) {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"4\",\"parkingSpaceStatus\":\"0\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    } else {
        client.post("/api/parking/status", contentType, "{\"parkingSpaceId\":\"4\",\"parkingSpaceStatus\":\"1\"}");
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
    }
}

void post() {
    if (gate == 1) {
        Serial.println("making POST request");
        String contentType = "application/json";
        String postData = "{\"tollgateStatus\":\"close\"}";
        client.post("/api/parking/status", contentType, postData);
        int statusCode = client.responseStatusCode();
        String response = client.responseBody();
        Serial.print("Status Code: ");
        Serial.println(statusCode);
        Serial.print("Response: ");
        Serial.println(response);
        Serial.println("Wait five seconds");
        delay(5000);
    }
}

void printSpaceInfo() {
    Serial.println("-----------");
    Serial.print("Tollgate Status: ");
    Serial.println(tollgateStatus);

    Serial.print("Parking Space 1 ID: ");
    Serial.println(space1);
    Serial.print("Parking Space 1 Status: ");
    Serial.println(space1Status);
    Serial.println("-----------");

    Serial.print("Parking Space 2 ID: ");
    Serial.println(space2);
    Serial.print("Parking Space 2 Status: ");
    Serial.println(space2Status);
    Serial.println("-----------");

    Serial.print("Parking Space 3 ID: ");
    Serial.println(space3);
    Serial.print("Parking Space 3 Status: ");
    Serial.println(space3Status);
    Serial.println("-----------");

    Serial.print("Parking Space 4 ID: ");
    Serial.println(space4);
    Serial.print("Parking Space 4 Status: ");
    Serial.println(space4Status);
    Serial.println("-----------");
}

void screen() {
    space1count = (strcasecmp(space1Status, "available") == 0) ? 1 : 0;
    space2count = (strcasecmp(space2Status, "available") == 0) ? 1 : 0;
    space3count = (strcasecmp(space3Status, "available") == 0) ? 1 : 0;
    space4count = (strcasecmp(space4Status, "available") == 0) ? 1 : 0;

    parkingcount = space1count + space2count + space3count + space4count;

    lcd.clear();
    lcd.print("Available Space:");
    lcd.setCursor(0, 1);
    lcd.print(parkingcount);
    lcd.setCursor(1, 1);
    lcd.print("/");
    lcd.setCursor(2, 1);
    lcd.print("4");
    if (parkingcount == 4) {
        lcd.setCursor(4, 1);
        lcd.print("Available");
    } else {
        lcd.setCursor(4, 1);
        lcd.print("Full");
    }
    delay(2000);
    
    lcd.clear();
    lcd.print("Parking No ");
    lcd.setCursor(12, 0);
    lcd.print(space1);
    lcd.setCursor(10, 0);
    lcd.print(":");
    lcd.setCursor(0, 1);
    lcd.print(space1Status);
    delay(2000);
    
    lcd.clear();
    lcd.print("Parking No ");
    lcd.setCursor(12, 0);
    lcd.print(space2);
    lcd.setCursor(10, 0);
    lcd.print(":");
    lcd.setCursor(0, 1);
    lcd.print(space2Status);
    delay(2000);
    
    lcd.clear();
    lcd.print("Parking No ");
    lcd.setCursor(12, 0);
    lcd.print(space3);
    lcd.setCursor(10, 0);
    lcd.print(":");
    lcd.setCursor(0, 1);
    lcd.print(space3Status);
    delay(2000);
    
    lcd.clear();
    lcd.print("Parking No ");
    lcd.setCursor(12, 0);
    lcd.print(space4);
    lcd.setCursor(10, 0);
    lcd.print(":");
    lcd.setCursor(0, 1);
    lcd.print(space4Status);
    delay(2000);
}
