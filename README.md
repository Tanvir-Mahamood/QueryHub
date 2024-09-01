# QueryHub
## Description:
This project is a web-based forum designed for programmers to discuss coding problems collaboratively. Users can sign up and securely login, browse existing categories, or create new ones. 
They can then create new threads with their coding problems and receive help from other users through comments. The forum also includes a search functionality to find specific topics. 
The project is a CRUD (Create, Read, Update, Delete) application, ensuring that users can manage their own content.

## Features:
- User Authentication:  User Registration and Login with secure authentication
- Category Management:  Browse existing or create new categories
- Thread Creation:      Post problems with details
- Commenting:           Users can respond and solve problems in threads
- Search Functionality: Find specific topics within the forum
- CRUD Operations:      Users can edit or delete their own threads and comments
  
> [!NOTE]
> Each thread consists of Thread-Title and Thread-Description.

## Usage
- Sign Up: Create a new account by filling in the required details on the signup page.
> [!WARNING]
> Duplication of email and username is restricted.
- Log In: Use your credentials to log in securely.
- Create or Select Categories: Choose an existing category or create a new one to organize your threads.
- Post Threads: Share your problems by creating a new thread in the appropriate category.
- Comment on Threads: Provide solutions or ask further questions by commenting on threads.
- Search: Use the search bar to find specific threads.
- Edit/Delete: Manage your threads and comments by editing or deleting them as needed.
- Watch other users profile and their activities.
> [!IMPORTANT]
> Email addresses of other users are hiddden.

## Technologies Used:
- Frontend:
  - HTML
  - Bootstrap
  - JavaScript
- Backend:
  - PHP
  - SQL (XAMPP Server)
- Data Table:
  - JTable

## Running the Project:
- Download and Install XAMPP Server: Follow the [official XAMPP website](https://www.apachefriends.org/download.html) instructions for your operating system. [Download and install XAMPP](https://www.apachefriends.org/)
- Clone the Project:                 Clone the project repository from GitHub using Git. Keep all the project file in a folder named `forum`. 

```
git clone https://github.com/Tanvir-Mahamood/QueryHub.git
```

- Configure Database:                Create a database within XAMPP and import the provided [SQL script](https://github.com/Tanvir-Mahamood/QueryHub/blob/main/index.php).
- Project Directory:                 Move the folder `forum` to the appropriate directory within your XAMPP server's document root.
- Database Configuration:            Edit the connection details in the [_dbconnection.php](https://github.com/Tanvir-Mahamood/QueryHub/blob/main/partials/_dbconnect.php) to point to your created database.
- Start XAMPP:                       Launch XAMPP and ensure Apache and MySQL are running.
- Access the Forum:                  Open your web browser and navigate to `http://localhost/[your_project_directory] (i.e. http://localhost/forum/)`


## Further Development:
- Implement additional user features (e.g., user profile-picture, user profile editing, reputation points)
- Integrate social media login options
- Enhance search functionality with advanced filters
- Build a notification system for user interaction

## Contact:
For any inquiries or support, please contact `deltatanvir2002@gmail.com`.
