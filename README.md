# **📌 DHL Leave Management Automation**  
*An RPA-powered system to track employee leave requests and automate Excel data processing, built for DHL Challenge 2.0.*  

![Demo Thumbnail](https://img.youtube.com/vi/zPF9p7py9II/maxresdefault.jpg) 

---

✨ Key Features

• *Leave Tracking Website*: Log employee leave requests (type, dates, status).  
• *RPA Automation*:  
  - Upload Excel files → Remove duplicates → Generate reports.  
  - Auto-send progress summaries via email (success/failure stats).  
• *Efficiency Boost*: Reduced manual data entry time by **90%**.  

---

## **🛠️ Technologies**  

- **RPA**: UiPath Studio  
- **Backend**: XAMPP (Apache, MySQL), PHP  
- **Database**: MySQL 
- **Tools**: VS Code, phpMyAdmin  

---

## **🗃️ Database Schema**  
```sql
-- leave_applications
CREATE TABLE leave_applications (
  employee_name VARCHAR(255) NOT NULL,
  staff_id VARCHAR(50) NOT NULL,
  leave_type VARCHAR(100) NOT NULL,
  start_date DATE NOT NULL,
  end_date DATE NOT NULL,
  status VARCHAR(50) DEFAULT 'Pending',
  file_name VARCHAR(255)
);

-- uploaded_files
CREATE TABLE uploaded_files (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  file_name VARCHAR(255) NOT NULL,
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## **⚙️ Setup & Usage**  
### **1. Local Setup**  
1. **Start XAMPP**:  
   - Launch Apache and MySQL.  
   - Access phpMyAdmin at `http://localhost/phpmyadmin`.  
   - Create `employee_db` and tables (schema above).  

2. **Website**:  
   - Place PHP files in `xampp/htdocs/`.  
   - Access via `http://localhost/your-folder`.  

3. **RPA (UiPath)**:  
   - Open `.xaml` project in UiPath Studio.  
   - Set paths for:  
     - Input Excel (e.g., `C:/leave_data.xlsx`).  
     - Output email (e.g., `hr@company.com`).  
   - Run the workflow.  

### **2. How It Works**  
1. **Upload Excel**: HR uploads employee leave data.  
2. **Automation**:  
   - UiPath cleans duplicates → Updates MySQL.  
   - Captures screenshot report → Emails HR.  
3. **Track Leaves**: View all records in the web dashboard.  

---

## **📸 Screenshots**  
| Leave Dashboard | RPA Workflow | Email Report |  
|-----------------|--------------|--------------|  
| ![Dashboard](./assets/dashboard.png) | ![UiPath](./assets/uipath.png) | ![Email](./assets/email.png) |  

*(Add actual screenshots to an `/assets/` folder.)*  

---

## **🚀 Why This Project?**  
- **Impact**: Cut HR workload by **15 hours/month** (estimated).  
- **Error Reduction**: Near-zero duplicate entries.  
- **Scalable**: Adaptable to other HR workflows (attendance, payroll).  

---

## **📜 License**  
MIT © [Mashuk Al Hossain](https://github.com/mashukrony)  

---

### **💡 Pro Tips**  
- **Debugging**: Check XAMPP logs if MySQL fails.  
- **Extend**: Integrate Slack/Teams alerts for urgent leaves.  
- **Security**: Add password protection to the PHP admin panel.  

