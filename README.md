# Photogram

Photogram is a secure photo-sharing web application built to demonstrate real-world secure coding practices and hybrid database architecture. It was developed as an independent project outside of academic coursework, with a strong emphasis on backend hardening, exploit mitigation, and secure system design.

> ⚠️ **Security Notice:**  
> This repository contains a **sanitized version** of the original codebase. Due to potential security risks and sensitive implementation details, the full production-grade source code is **not publicly available**. If you're interested in reviewing specific components or discussing the architecture, feel free to reach out.

---

## Project Overview

Photogram enables users to upload, view, and manage photos in a privacy-focused environment. It integrates both structured and unstructured data storage using a hybrid database setup.

### Key Technologies
- **Backend:** PHP
- **Databases:** MySQL (user data, sessions), MongoDB (photo metadata)
- **Containerization:** Docker
- **Web Server:** Apache
- **Admin Tools:** phpMyAdmin, Mongo Express
- **Security Practices:** CSRF protection, input validation, session management, prepared statements

---

## Features

- **Authentication & Access Control**
  - Bcrypt-based password hashing
  - Role-based permissions
  - Session hijack prevention

- **Secure File Handling**
  - MIME type validation
  - Sandboxed image storage
  - File size restrictions

- **Hybrid Database Architecture**
  - MySQL for structured relational data
  - MongoDB for flexible document storage

- **Security Enhancements**
  - CSRF tokens
  - XSS mitigation via output encoding
  - SQL injection prevention
  - Dockerized deployment for isolation
