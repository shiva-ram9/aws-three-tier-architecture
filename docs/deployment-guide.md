# AWS Three-Tier Architecture – Deployment Guide

## 1. Create the VPC

Create a VPC with:

- CIDR: `10.0.0.0/16`
- 2 Availability Zones
- Public and private subnets

## 2. Create Subnets

### Public Subnets
Used for:

- Application Load Balancer
- NAT Gateway

### Private Application Subnets
Used for:

- EC2 instances
- Application workloads

### Private Database Subnets
Used for:

- Amazon RDS

## 3. Configure Internet Gateway

Attach an Internet Gateway to the VPC.

Configure the public route table:

```text
0.0.0.0/0 → Internet Gateway
