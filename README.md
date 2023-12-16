<p align="center">
  <a href="" rel="noopener"><img width=200px height=200px src="web-panel/public/img/logo.png" alt="IoT Parking System Logo"></a>
</p>

<h3 align="center">IoT Parking System</h3>

<div align="center">

[![Status](https://img.shields.io/badge/status-active-success.svg)]()
[![GitHub Issues](https://img.shields.io/github/issues/dnachavez/iotparkingsystem.svg)](https://github.com/dnachavez/iotparkingsystem/issues)
[![GitHub Pull Requests](https://img.shields.io/github/issues-pr/dnachavez/iotparkingsystem.svg)](https://github.com/dnachavez/iotparkingsystem/pulls)
[![License](https://img.shields.io/github/license/dnachavez/iotparkingsystem)](/LICENSE)

</div>

---

<p align="center">
  <a href="" rel="noopener"><img width=100% src="https://i.ibb.co/ynxNj2L/image.png" alt="IoT Parking System Logo"></a>
</p>

<p align="center">An IoT parking system project built using CodeIgniter 4 and Arduino Uno R4 WiFi for IT214 - IS Innovations and New Technologies subject.</p>

## 📝 Table of Contents

- [About](#about)
- [Getting Started](#getting_started)
- [Deployment](#deployment)
- [Usage](#usage)
- [Built Using](#built_using)
- [Contributing](../CONTRIBUTING.md)
- [Authors](#authors)

## 🧐 About <a name = "about"></a>

This project is designed to address the challenges of managing parking spaces in some areas of the university through the integration of IoT technologies. By utilizing Arduino Uno R4 WiFi and an array of sensors, the IoT Parking System provides real-time data on parking space availability, thereby enhancing the efficiency of parking management. This system not only simplifies the parking process but also aids administrators in monitoring and optimizing space usage.

## 🏁 Getting Started <a name = "getting_started"></a>

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See [deployment](#deployment) for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software and how to install them.

- Arduino IDE
- PHP environment with CodeIgniter 4
- MySQL for the database
- Web hosting for deploying the web panel

```
Download Arduino IDE: https://www.arduino.cc/en/software
```

### Installing

A step by step series of examples that tell you how to get a development env running.

1. Clone the repository to your local machine.
```
git clone https://github.com/dnachavez/iotparkingsystem.git
```
2. Ensure your PHP environment is correctly configured and MySQL is set up.
3. Run ```php spark migrate:refresh``` to create fresh database tables.
- Seed the database by executing:
- ```php spark db:seed ConstantSeeder```
- ```php spark db:seed UserSeeder```
- ```php spark db:seed ParkingSpaceSeeder```
4. After completing the installation steps, you can proceed to log in to the system.
- Use the default credentials:
- Username: ```admin```
- Password: ```admin123```

## 🎈 Usage <a name="usage"></a>

Before you can use the web panel with the Arduino Uno R4 WiFi, ensure the system is deployed in a live environment. Set the base URL from the live environment in the Arduino code, along with your WiFi credentials.

To access the panel, login with the following credentials:
- Username: ```admin```
- Password: ```admin123```

You can manually set parking spaces as available and unavailable, and set reservation by clicking the parking space.

To open the tollgate, click the ```TG``` button in the panel.

You can view the parking reservations and parking history by clicking the ```Reservations``` and ```History``` in the bottom menu.

## 🚀 Deployment <a name = "deployment"></a>

Deploy the web panel to a live web hosting service. Configure the Arduino system to communicate with the live web panel by setting the appropriate base URL and WiFi credentials in the Arduino code.

## ⛏️ Built Using <a name = "built_using"></a>

- [CodeIgniter 4](https://www.arduino.cc/) - PHP Framework
- [MySQL](https://www.arduino.cc/) - Database
- [Arduino Uno R4 WiFi](https://www.arduino.cc/) - IoT Platform

## ✍️ Authors <a name = "authors"></a>

- [@dnachavez](https://github.com/dnachavez) - Idea & Initial work

See also the list of [contributors](https://github.com/dnachavez/iotparkingsystem/contributors) who participated in this project.
