/* This arduino code is sending data to mysql server every 30 seconds.

Created By Embedotronics Technologies*/

#include "DHT.h"
#include <ESP8266WiFi.h>
#include <WiFiClient.h>
#include <ESP8266HTTPClient.h>
#include <ESP8266WebServer.h>
#include <SimpleTimer.h>
#include <ESP8266mDNS.h>
#include <SPI.h>
#include <MFRC522.h>

#define DHTPIN D1

#define DHTTYPE DHT11

DHT dht(DHTPIN,DHTTYPE);
WiFiClient client;  
HTTPClient http;
SimpleTimer simpleTimer;

int device = 2;
float humidityData=0;
float temperatureData=0;
int relay = D4;
int buzzer = D7; // GPIO13---D7 of NodeMCU
int LED = D6;
int photocell = A0;
int photocellData = 0;
int percentage =0;

const char* ssid = "sayed";// 
const char* password = "12345678";
//WiFiClient client;
char server[] = "sayedfyp.000webhostapp.com"; //"192.168.137.1";   //eg: 192.168.0.222
//const char* host = "http://sayedfyp.000webhostapp.com/fypsayed/sayed_IoT/Getstatus.php";
const char* host_relay = "http://sayedfyp.000webhostapp.com/fypsayed/sayed_IoT/Getstatus.php?device=1&actuator=6";//http host 
const char* host_buzzer = "http://sayedfyp.000webhostapp.com/fypsayed/sayed_IoT/Getstatus.php?device=1&actuator=5";//http host
const char* host_LED = "http://sayedfyp.000webhostapp.com/fypsayed/sayed_IoT/Getstatus.php?device=2&actuator=9";//http host 


void setup()
{
  Serial.begin(115200);
  dht.begin();

  // Connect to WiFi network
  Serial.println();
  Serial.println();
  Serial.print("Connecting to ");
  Serial.println(ssid);
 
  WiFi.begin(ssid, password);
 
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
 
  // Start the server
//  server.begin();
  Serial.println("Server started");
  Serial.print(WiFi.localIP());
  delay(1000);
  Serial.println("connecting...");
  
   // Pin for relay module set as output
  pinMode(relay, OUTPUT);
  digitalWrite(relay, HIGH);
  
 //pin for alarm buzzer set as output
  pinMode(buzzer, OUTPUT);
  digitalWrite(buzzer, LOW);

  //LED Setup
  pinMode (LED, OUTPUT);
  digitalWrite (LED, HIGH);
  //delay(10);
  //simpleTimer.setInterval (5000L, Senddata_To_Database);

  //photocell pin mode setup
  pinMode (photocell, INPUT);
 }
 
void loop()
{
  //simpleTimer.run(); 
  humidityData = dht.readHumidity();
  temperatureData = dht.readTemperature(); 
  photocellData = analogRead(photocell);// read the analog value of the photocell sensor with the range of (0-1024)
  percentage = map (photocellData, 0, 1024, 0, 100);  //convert analog reading into percentage
  //float voltage = photocellData * (5.0 / 1023.0); // Convert the analog reading (which goes from 0 - 1023) to a voltage (0 - 5V)

  if (isnan(humidityData) || isnan(temperatureData)){
    humidityData=0;
    temperatureData = 0;
  }
  
  Senddata_To_Database(); //function called
  Getdata_From_Database(); //function called

  Serial.print("Display the Photocell Data into Percentage(%): ");
  Serial.println(percentage);
  
  tone(buzzer,1000,200);
  delay(10000); // interval delay 10s

  
/****************************************************This code section for Testing*************************************/
  /*if (val<=200){
    digitalWrite (LED, LOW);
  }else digitalWrite (LED, HIGH);*/
  
  //digitalWrite(LED,val/20);// turn on the LED and set up brightness（maximum output value 255）
  //delay(10);// wait for 0.01
  
//digitalWrite(LED, HIGH);
//digitalWrite (relay, HIGH);
//delay(500);
//digitalWrite (relay, LOW);
//digitalWrite(LED, LOW);
//delay(500); // interval

 }

 /****************This Function for Send Sensor Data to Server Database ******************************************/

 void Senddata_To_Database()   //CONNECTING WITH MYSQL
 { 

   if (client.connect(server, 80)) {

    Serial.println("\n\n\n connected");
    // Make a HTTP request:
    Serial.print("GET fypsayed/sayed_IoT/sayed_IoT.php?device=");
    client.print("GET /fypsayed/sayed_IoT/sayed_IoT.php?device=");     //YOUR URL
    Serial.print(device);
    client.print(device);
    Serial.print("&humidity=");
    client.print("&humidity=");
    Serial.print(humidityData);
    client.print(humidityData);
    client.print("&temperature=");
    Serial.print("&temperature=");
    client.print(temperatureData);
    Serial.print(temperatureData);
    client.print("&photocell=");
    Serial.print("&photocell=");
    client.print(percentage);
    Serial.println(percentage);
    client.print(" ");      //SPACE BEFORE HTTP/1.1
    client.print("HTTP/1.1");
    client.println();
    client.println("Host: sayedfyp.000webhostapp.com");
    client.println("Connection: close");
    client.println();
  } else {
    // if you didn't get a connection to the server:
    Serial.println("connection failed");
  }
 }

 /****************************This Function for Getting Updated Sensor Status from the Server Database**************************/

 void Getdata_From_Database()
 {
  //http.begin(host_relay);
  http.begin(host_LED);
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.GET();
  String payload = http.getString(); // get data from webhost continously
  Serial.print("Sensor Status: ");
  Serial.print(payload);
  Serial.println(".");
  
  if(payload == "1")  // if data == 1 -> LED ON
  {
  Serial.println("[1]");
    digitalWrite(D4,HIGH);
    digitalWrite(D6,HIGH);
    }
   else if (payload == "0") // if data == 0 -> LED OFF
   {
  Serial.println("[0]");
    digitalWrite(D4,LOW);
    digitalWrite(D6,LOW);
    }
  
  delay(500);
   http.end();
 }
