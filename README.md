# WheelyFast - Online Car Rental System

This project is an online car rental system, built using **PHP**, **CSS**, **JavaScript** (vanilla), and **MySQL** for data management. The system incorporates **AJAX** to create a dynamic, interactive experience without relying on any front-end frameworks. It was developed as part of a university assignment in the course **32516 Internet Programming** during the 2024 Autumn Session at the **University of Technology Sydney**.

## Features

- **Search and Browse**: 
  - Users can search for cars by model, brand, or type using a search bar with real-time suggestions.
  - Cars are categorised by type (e.g., Sedan, Ute) and brand (e.g., Ford, Tesla), and users can browse cars in each category.
  - Both search results and categories are displayed in a grid format, showing car details such as model, price per day, availability, and an option to rent the car.

- **Reservation**:
  - Users can select a car and proceed to the reservation page, where they can specify rental dates and adjust the quantity (if multiple cars are available).
  - The total rental cost is calculated in real time based on the rental period and car price.
  - Users must provide their name, phone number, email, and confirm they have a valid driver’s license before placing an order.
  - Users can confirm or cancel their reservation, and the system stores incomplete reservations for later retrieval via sessions or cookies.

- **Order Confirmation**:
  - Once an order is placed, the system prompts users to confirm their booking by clicking a confirmation link, secured with a randomly generated verification code.
  - After confirmation, the system updates the car availability in the **MySQL** database and updates the number of bookings on that car in the **JSON** file (as per course requirement).
  - Users can cancel their confirmed booking if needed, and the system will update the car's availability accordingly.

- **Interactive Design**:
  - Visual feedback is provided for categories, search results, and buttons when hovered or clicked.
  - Disabled buttons (e.g., when a car is unavailable) appear in a different style to improve clarity for the user.
  - The system features a responsive layout for different desktop display sizes.

## Screenshots

### Homepage with car detail page

![Homepage with car detail page](http://alexanderclausen.com/portfolio/projects/wheelyfast/wheelyfast.png)

### Filtered Car Grid

![Filtered Car Grid](http://alexanderclausen.com/portfolio/projects/wheelyfast/wheelyfast_1.png)

### Car Reservation Form

![Car Reservation Form](http://alexanderclausen.com/portfolio/projects/wheelyfast/wheelyfast_2.png)

### Booking Confirmation Page (Confirmed)

![Confirmed Booking](http://alexanderclausen.com/portfolio/projects/wheelyfast/wheelyfast_3.png)


## Future Improvements

- **Responsive Design**: Allow accessible usage on mobile devices.
- **Payment Integration**: Implement a payment gateway to allow users to complete their rental booking with an online payment.
- **Multi-car Rentals**: Expand the system to support multiple (different) car rentals in a single reservation.
- **User Authentication**: Introduce account creation and login functionality to provide a personalised booking experience.
