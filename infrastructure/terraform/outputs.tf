output "alb_dns_name" {
  description = "Public DNS name of the Application Load Balancer."
  value       = aws_lb.main.dns_name
}

output "rds_endpoint" {
  description = "Private RDS endpoint."
  value       = aws_db_instance.main.address
}

output "vpc_id" {
  description = "Created VPC ID."
  value       = aws_vpc.main.id
}

