# 🤖 Robot Arm Control Panel

This project is a control panel for a robot arm built using **Flutter** for the frontend and **PHP + MySQL** for the backend. The system allows the user to control four servo motors, save poses to a database, run saved poses, and delete them.

---

## 🧠 What This Project Does

- Control 4 servo motors using sliders.
- Save the current pose (servo positions) to a MySQL database.
- View saved poses in a scrollable list.
- Run a specific saved pose (loads the servo values into the UI).
- Delete any saved pose.

---

## 🧰 Technologies Used

- **Frontend:** Flutter (Dart)
- **Backend:** PHP
- **Database:** MySQL (via MAMP)
- **Local Server:** MAMP (for macOS)

---

How I Made the Task

 1. Created the UI Using Flutter

- Used `Slider` widgets for servo 1 to 4.
- Buttons for `Reset`, `Save Pose`, `Run`.
- Used a `ListView` to display saved poses.
- Added HTTP communication using `http` package.

 2. Used MySQL Database (`TASK3`) from previous task

 3. Wrote the Backend in PHP (in /web_task3)
    - save_pose.php — inserts a new pose into pose table.
    - get_saved_poses.php — fetches all saved poses as JSON.
    - get_run_pose.php — returns a pose by ID.
    - delete_pose.php — deletes a pose by ID.
    - update_status.php — sets status = 0 for a pose.

   
 4. Connected Flutter to PHP
    - Used real IP from ipconfig getifaddr en0 to make Flutter send HTTP requests to MAMP backend.
    - All buttons are linked to HTTP POST or GET endpoints.
    - Poses are displayed dynamically using data from MySQL.



UI 
<img width="304" height="522" alt="Screenshot 2025-08-02 at 7 41 05 PM" src="https://github.com/user-attachments/assets/eaf453e9-ccea-4fc5-9a6b-6b8c4585c149" />


saved to the database 
<img width="502" height="130" alt="Screenshot 2025-08-02 at 7 41 25 PM" src="https://github.com/user-attachments/assets/fd5aa667-7a1e-41e2-858d-d469b7a69568" />



