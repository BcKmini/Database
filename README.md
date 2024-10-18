# 🏥 **Comprehensive Medical Management Service**

## 👥 **Team Members**:

🆔 **Byun Seonwoo**
🆔 **Kim Kyungmin**
🆔 **Lim Hoeyeon**

## 🛠️ **Technology Stack**

### 💻 **Languages & Tools Used**:

| **Category**       | **Technologies/Tools**                                                                 |
|--------------------|----------------------------------------------------------------------------------------|
| **Frontend**        | - HTML5<br> - CSS3<br> - JavaScript                                                    |
| **Backend**         | - PHP<br> - MySQL (for database management)                                            |
| **APIs**            | - KaKao Map API (for hospital/pharmacy search and map functionalities)<br> - Public data Hospital Information [https://www.data.go.kr/](https://www.data.go.kr/) |
| **Data Management** | - SQL (for querying the database)                                                      |


## 📋 **Project Overview**

This project provides a **Unified Medical Service System** that aims to:

- 🚶 **Reduce patient waiting times**
- 📝 **Enable digital prescriptions**
- 🌿 **Promote eco-friendly practices by reducing paper use**

The system integrates hospitals, pharmacies, and patients, allowing for efficient management of medical records, prescription uploads/downloads, and user reviews, thereby enhancing the healthcare experience.

## 🎯 **Project Goals**

- **Integration of Medical Services**: A unified platform for seamless management of patient, hospital, and pharmacy data.
- **Reduce Waiting Times**: Streamlined processes to minimize waiting times at medical facilities.
- **Digital Prescription Management**: Patients can securely manage prescriptions, reducing paper consumption.

## ✨ **Core Features**

### 🏥 **Search & View Hospital/Pharmacy Information**

- 🔍 Search for hospitals and pharmacies via an interactive map.
- 📞 Access details like contact numbers, addresses, and working hours.
- 🔑 Only registered members (hospital/pharmacy or patients) can access detailed information.

### 📂 **Prescription Upload/Download**

- Patients can securely upload and download prescriptions.
- Ensures data security with strict document handling protocols.

### 📝 **Hospital/Pharmacy Reviews**

- Users can write and view reviews for hospitals and pharmacies they visit.
- Clicking on a location on the map displays the review page with detailed information.

## 🏥 **User Requirements**

### 👤 **Patient Requirements**

- **Easy Registration**: Patients register using their name and ID number.
- **Access Medical Information**: Patients can view prescriptions and medical records to ensure accurate treatments.
- **Review System**: View and write reviews for hospitals and pharmacies to share feedback.

### 🏨 **Hospital/Pharmacy Requirements**

- **Access to Patient Info**: Hospitals/pharmacies can easily access patient info after secure login.
- **Prescription Management**: Medical professionals can upload and manage prescriptions securely.
- **Improvement via Feedback**: Hospitals and pharmacies can use patient reviews for service improvement.

## 🔐 **Security Features**

- **Mandatory License Upload**: Hospital/Pharmacy registration requires license upload for security compliance.
- **Prescription Security**: Prescriptions are automatically deleted from the database after being downloaded to maintain privacy.

## 📊 **Database Design**

The system features a well-structured relational database to manage users, hospitals, pharmacies, and reviews efficiently.

### 🗂 **Personal Table**
Stores patient information such as name, ID, contact details, medical history, and prescriptions.

### 🏥 **Hospital Table**
Stores data on hospitals including license numbers, contact information, and working hours.

### 💊 **Pharmacy Table**
Stores data on pharmacies, including licenses, working hours, and location details.

### ✍️ **Review Table**
Tracks patient reviews with fields for place name, author, content, and rating.

### 📊 **ER Model & Tables**

Our project is built on a robust **Entity-Relationship Model (ER Model)** that efficiently connects the relationships between patients, hospitals, pharmacies, and reviews. This ensures that data is securely handled and available when needed.

## 💻 **Main Functionalities**

- 🔑 **User Registration & Login**:
Supports registration for patients, hospitals, and pharmacies with role-based access controls.

- 🏥 **Hospital/Pharmacy Search**:
Provides an interactive map to search for hospitals and pharmacies, view their reviews, and access detailed information like working hours.

- 📂 **Prescription Management**:
Patients can upload and download prescriptions securely, with careful management of sensitive data.

- 📝 **Review System**:
Patients can view and leave feedback about hospitals and pharmacies, allowing for service improvement based on reviews.
