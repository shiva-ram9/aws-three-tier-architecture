# AWS Three-Tier Architecture Deployment Guide

## 1. Create the network

1. Select `ap-south-2`.
2. Create VPC `10.0.0.0/16`.
3. Create two public, two private application, and two private database subnets across two Availability Zones.
4. Attach an Internet Gateway.
5. Associate both public subnets with a route table containing `0.0.0.0/0 → Internet Gateway`.
6. Keep application and database subnets private.

## 2. Configure security groups

| Security group | Inbound rule |
|---|---|
| ALB SG | HTTP 80 from `0.0.0.0/0` |
| Application SG | HTTP 80 from the ALB SG |
| RDS SG | MySQL 3306 from the Application SG |

Keep the default outbound rule during the lab. Do not add SSH access when using Systems Manager.

## 3. Create the database tier

1. Create an RDS DB subnet group using the two private database subnets.
2. Create an RDS for MySQL instance.
3. Disable public access.
4. Select the project VPC, DB subnet group, and RDS security group.
5. From an application EC2 session, connect with:

```bash
mysql -h YOUR_RDS_ENDPOINT -P 3306 -u admin -p
```

6. Create and verify the application database:

```sql
CREATE DATABASE IF NOT EXISTS appdb;
USE appdb;
SHOW DATABASES;
```

## 4. Build the application image

1. Create an IAM role with `AmazonSSMManagedInstanceCore`.
2. Launch an Amazon Linux 2023 EC2 instance in a private application subnet.
3. Attach the Application SG and IAM instance profile.
4. If package installation is required, create a temporary NAT Gateway and add a default route from the application subnet route tables.
5. Install and start Apache, then create the health endpoint:

```bash
sudo dnf install -y httpd
sudo systemctl enable --now httpd
echo healthy | sudo tee /var/www/html/health.html
curl -v http://localhost/health.html
```

6. Validate RDS connectivity.
7. Create an AMI from the configured instance.
8. Remove the temporary NAT Gateway, its routes, and its Elastic IP after package installation is complete.

## 5. Configure scaling and load balancing

1. Create a launch template from the AMI with the IAM role and Application SG.
2. Create a target group on HTTP port 80.
3. Set the health-check path to `/health.html`.
4. Create an Auto Scaling Group across both private application subnets:
   - Minimum: 2
   - Desired: 2
   - Maximum: 4
5. Attach the target group.
6. Create an internet-facing Application Load Balancer across both public subnets.
7. Attach the ALB SG and forward HTTP port 80 to the target group.
8. Enable ELB health checks on the Auto Scaling Group.

## 6. Validate

Confirm all of the following:

- Two ASG instances show `InService`.
- Both target-group instances show `Healthy`.
- `curl -v http://ALB_DNS_NAME/health.html` returns HTTP 200.
- EC2 can connect to RDS on port 3306.
- RDS remains private.
- A CloudWatch alarm monitors CPU utilization.

## 7. Clean up

To avoid unexpected charges, remove resources in dependency order when finished: Auto Scaling Group, load balancer, target group, launch template/AMI snapshots if no longer needed, RDS, remaining EC2 resources, NAT Gateway and Elastic IP, then VPC networking resources.
