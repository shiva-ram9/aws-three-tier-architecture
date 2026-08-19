# Architecture

The deployed environment follows a three-tier design across two Availability Zones in `ap-south-2`.

## Request flow

1. A client sends an HTTP request to the internet-facing Application Load Balancer.
2. The ALB forwards the request to a healthy EC2 instance managed by the Auto Scaling Group.
3. The application connects to Amazon RDS for MySQL on port 3306.
4. Security groups permit only the required tier-to-tier traffic.

## Diagram

![AWS three-tier architecture](../architecture-diagram.png)

## Tier placement

| Tier | Subnets | Components |
|---|---|---|
| Presentation | Two public subnets | ALB and Internet Gateway route |
| Application | Two private application subnets | EC2, launch template and Auto Scaling |
| Database | Two private database subnets | RDS and DB subnet group |

The temporary NAT Gateway used during package installation was removed after image creation to reduce ongoing cost.

