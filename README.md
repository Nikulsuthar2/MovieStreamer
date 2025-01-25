# Movie Streaming & Subscription Website

A basic movie streaming and subscription platform developed in PHP and MySQL. The project features two modules: **Admin** and **User**, with core functionalities for managing movies, users, subscriptions, and streaming movies from a local server.



## Features

### User Module
- **User Registration & Login**: Secure signup and login system for users.
- **Home Page**: Displays categorized movies 
- **Search Bar**: Search movies by title.
- **Movie Details Page**:
  - When clicking on a movie card, users are redirected to the movie player page.
  - The movie player streams movies hosted on a local PHP Apache server.
  - Displays movie details.
- **User Profile**:
  - Displays user details.
  - Displays subscription details.
  - Wishlist of movies.

### Admin Module
- **Admin Login**: login system for administrators.
- **Dashboard**: Overview of system statistics.
- **Manage Movies & Actors**:
  - Add, edit, and delete movies.
  - Manage actor details.
- **Manage Subscriptions**:
  - View and update subscription plans.
- **User Management**: View and manage the list of registered users.
- **Purchase Records**: View the purchase history of user subscriptions.

### Additional Features
- **Simple Payment UI**:
  - Payment simulation interface to confirm subscription purchases (no actual payment gateway integrated).
- **Local Server-Based Movie Hosting**:
  - Movies are served from the local PHP Apache server instead of an actual streaming server.

---

## Technology Stack
- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS, JavaScript
- **Server**: XAMMP Apache (local server)

---

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Nikulsuthar2/MovieStreamer.git
   ```

2. **Setup the Database**
    - Create a database `moviestream` in phpMyAdmin
    - Import the provided `moviestream.sql` file from SQL folder into your phpMyAdmin MySQL server.
    - Update the database connection details in the `db.php` file both in Admin and User folder:
    ```php
    $hostname = "localhost";
    $username = "your_database_username";
    $password = "your_database_password";
    $database = "moviestream";
    ```

3. **Create `Content` Directory with these sub folders:**
    ```
    Content
        Actors
        Movie
        Poster
    ```

4. **Start the Local Server**
   - Ensure Apache and MySQL are running.
   - Place the project folder in the `htdocs` directory (if using XAMPP).
   - Access the website via `http://localhost/MovieStreamer/`.

5. **Admin Credentials**
   - Default admin credentials can be updated in the database under the `admin_dtl` table.
   - Default credentials are `admin@admin.com` and `adminadmin`

---

## Limitations
- Movies are streamed from the local server and not a dedicated streaming server.
- No actual payment gateway integration; only a mock payment UI is implemented.

---

## Future Enhancements
- Integrate a payment gateway (e.g., PayPal, Stripe) for subscription management.
- Implement a dedicated movie streaming server for better performance.
- Enhance UI/UX with a modern framework (e.g., React or Vue.js).
- Add support for multiple languages.

---

## Author
**Nikul Suthar** -> [Nikulsuthar2](https://github.com/Nikulsuthar2)

---
## Screenshots

![index](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/movieindex.png?raw=true)

![login](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/movielogin.png?raw=true)
![signup](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/moviesignup.png?raw=true)
![home](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/moviehome.png?raw=true)
![home2](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/moviehome2.png?raw=true)
![movie](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/movieplayer.png?raw=true)
![profile](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/movieprofile.png?raw=true)
![subscribe](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/subscription.png?raw=true)
![payment](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/moviepayment.png?raw=true)
![paymentsuccess](https://github.com/Nikulsuthar2/MovieStreamer/blob/main/Screenshot/moviepayrecipt.png?raw=true)

More Screenshot in `Screenshot` folder