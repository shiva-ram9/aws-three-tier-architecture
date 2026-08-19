# Enterprise AWS Three-Tier Web Architecture

A production-style AWS environment built in **Asia Pacific (Hyderabad), `ap-south-2`**. The project demonstrates network isolation, high availability at the application tier, controlled traffic between tiers, automatic instance replacement, database connectivity, and CloudWatch monitoring.

![Architecture diagram](architecture-diagram.png)

## Architecture

**Request flow**

Internet → Application Load Balancer → Auto Scaling EC2 instances → Amazon RDS for MySQL

| Tier | Placement | AWS resources |
|---|---|---|
| Presentation | Two public subnets across two Availability Zones | Internet-facing Application Load Balancer |
| Application | Two private application subnets | EC2, Launch Template, Auto Scaling Group, Systems Manager |
| Database | Two private database subnets | Amazon RDS for MySQL, DB subnet group |

## Network Design

| Resource | Configuration |
|---|---|
| Region | Hyderabad (`ap-south-2`) |
| VPC | `10.0.0.0/16` |
| Public subnets | `10.0.0.0/20`, `10.0.16.0/20` |
| Private application subnets | `10.0.128.0/20`, `10.0.144.0/20` |
| Private database subnets | `10.0.160.0/20`, `10.0.176.0/20` |
| Availability Zones | 2 |
| Public routing | Internet Gateway |
| Administration | AWS Systems Manager Session Manager |

A temporary NAT Gateway was used to install packages on private EC2 instances and was removed after configuration to prevent ongoing NAT charges.

## Security Design

- The ALB security group accepts HTTP on port 80 from the internet.
- The application security group accepts HTTP on port 80 only from the ALB security group.
- The RDS security group accepts MySQL on port 3306 only from the application security group.
- EC2 instances have no public IPv4 addresses and are managed through Systems Manager.
- RDS is not publicly accessible and is placed in private database subnets.
- IAM roles are used instead of access keys stored on EC2.

## High Availability and Scaling

- The ALB spans two public subnets in separate Availability Zones.
- The Auto Scaling Group maintains two EC2 instances across two private application subnets.
- Target-group health checks use `/health.html`.
- Unhealthy instances can be replaced automatically.
- Scaling limits are configured for 2–4 application instances.

## Validation Results

- Two Auto Scaling instances reached **InService**.
- Both target-group instances remained **Healthy**.
- The ALB health endpoint returned **HTTP 200**.
- EC2-to-RDS connectivity and a MySQL query were verified.
- A CloudWatch high-CPU alarm was created.
- The original standalone build instance was terminated after the AMI and launch template were validated.

## Skills Demonstrated

| Category | Services and concepts |
|---|---|
| Compute | EC2, AMIs, launch templates |
| Networking | VPC, subnets, route tables, Internet Gateway |
| Security | IAM roles, security groups, private workloads |
| Load balancing | Application Load Balancer, target groups, health checks |
| Scaling | EC2 Auto Scaling |
| Database | Amazon RDS for MySQL, DB subnet groups |
| Operations | Systems Manager Session Manager |
| Monitoring | Amazon CloudWatch alarms |

## What I Learned

- Designed a six-subnet VPC across two Availability Zones.
- Configured least-privilege traffic paths between ALB, application, and database tiers.
- Built an AMI-based launch template and an Auto Scaling Group.
- Diagnosed target health-check timeouts across security groups, routes, and the web server.
- Validated private EC2-to-RDS connectivity without exposing either resource publicly.
- Removed temporary billable networking resources after deployment.

## Deployment Guide

See [docs/deployment-guide.md](docs/deployment-guide.md).

## Cost Notice

This project can incur AWS charges for RDS, ALB, EC2, public IPv4 addresses, storage, data transfer, and monitoring. Delete or stop resources when the lab is not in use.
