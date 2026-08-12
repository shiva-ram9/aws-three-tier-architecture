# Enterprise AWS Three-Tier Web Application Architecture

## 📌 Project Overview

This project demonstrates an enterprise-style three-tier web application architecture built on Amazon Web Services (AWS).

The architecture is designed for:

- High availability
- Scalability
- Fault tolerance
- Network isolation
- Security
- Load balancing

## 🔹 Three-Tier Architecture

### 1. Presentation Layer

Handles incoming user requests.

**AWS Services:**

- Amazon Route 53
- Application Load Balancer (ALB)
- Public Subnets

### 2. Application Layer

Runs the application workload.

**AWS Services:**

- Amazon EC2
- Auto Scaling
- Private Application Subnets

### 3. Database Layer

Stores application data securely.

**AWS Services:**

- Amazon RDS
- Private Database Subnets
- Multi-AZ deployment

## ☁️ AWS Services Used

| Category | AWS Service |
|---|---|
| DNS | Amazon Route 53 |
| Networking | Amazon VPC |
| Load Balancing | Application Load Balancer |
| Compute | Amazon EC2 |
| Scaling | EC2 Auto Scaling |
| Database | Amazon RDS |
| Security | IAM, Security Groups |
| Monitoring | Amazon CloudWatch |
| Logging | AWS CloudTrail |
| Encryption | AWS KMS |
| Internet Access | Internet Gateway / NAT Gateway |

## 🔐 Security Design

- Application servers are deployed in private subnets.
- Database servers are isolated in private database subnets.
- Security Groups restrict traffic between tiers.
- IAM roles are used instead of storing credentials on EC2 instances.
- Database access is restricted to the application tier.
- Encryption can be enabled using AWS KMS.

## 📈 High Availability

The architecture is designed across multiple Availability Zones.

- Application Load Balancer distributes traffic.
- EC2 Auto Scaling provides application scalability.
- RDS Multi-AZ provides database availability.
- Multiple subnets improve fault tolerance.

## 🚀 Deployment

Detailed deployment instructions are available here:

[Deployment Guide](docs/deployment-guide.md)

## 📂 Project Structure

```text
aws-three-tier-architecture/
│
├── README.md
├── architecture-diagram.png
│
├── docs/
│   └── deployment-guide.md
│
└── screenshots/
    └── README.md
