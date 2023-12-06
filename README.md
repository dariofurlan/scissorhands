# 💈Barber Scissorhands
![image](https://github.com/BackToFrancesco/scissorhands/assets/76614857/ffae34d4-1e68-4cce-b641-c57458515d3c)

This project was developed as final project for Web Technologies 2021/2022 held by Prof. Ombretta Gaggi in Univeristy of Padova.


## Authors
[Francesco Bacchin](https://github.com/backtofrancesco), University of Padua, Italy

[Matteo Bellato](https://github.com/matt8227), University of Padua, Italy

[Leila Dardouri](https://github.com/leidard), University of Padua, Italy

[Dario Furlan](https://github.com/dariofurlan), University of Padua, Italy

## Introduction
This project originated from the idea of creating an online booking service for a barber shop in Padova, focusing particularly on accessibility and usability. The website is designed to be easily navigable for both regular and new customers, with special attention to youths and adults up to the age of fifty.

## Features
- **Online Booking:** Allows customers to book appointments online in a simple and intuitive way.
- **Staff and Services Information:** Dedicated page for staff with photos and biographies, as well as detailed descriptions of the services offered.
- **Gallery:** Displays previous works and the shop's environment through selected images.
- **Contact and Map:** Provides contact information, opening hours, and a static map for the shop's location.
- **Account Management:** Enables customers to register, access their profile, and view their booking history.

## Technologies Used
- **Frontend:** HTML5, CSS3 (with a Mobile First approach), and JavaScript for form validation and accessibility enhancements.
- **Backend:** PHP, with an architecture based on models, services, and controllers, and MySQL for database management.
- **Accessibility:** Focused on a wide range of users, with attention to text readability, simplified navigation, and compatibility with screen readers.

## Installation and Configuration
1. Clone the repository:
   ```
   git clone [repository URL]
   ```
2. Configure the `helper.php` file in the `models` path for database connection.
3. Import the provided SQL database.
4. Run the dev server
    ```bash
    php -S localhost:8000 -t controllers/
    ```

## Testing
The site has been extensively tested on various browsers (Chrome, Edge, Mozilla Firefox, Opera, and Safari) and validated with tools such as W3C HTML Validator and W3C CSS Validator. Accessibility was verified using the WAVE tool and NVDA screen reader.
