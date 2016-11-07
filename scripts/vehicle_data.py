#!/usr/bin/env python3
import rospy
from std_msgs.msg import String
from std_msgs.msg import Float64
from std_msgs.msg import Twist
import time
import csv

global vel_actual
global vel_target
global mode
global pid_output
global log_file

def callback_va(data):
    vel_actual = data.data
    log_file.write(time.strftime("%H:%M")+"\t\t"+str(vel_actual)+"\t\t")

def callback_vt(data):
    vel_target = data.data
    log_file.write(str(vel_target)+"\t\t")

def callback_pid(data):
    pid_output = data.linear.x
    if data.angular.y==1:
        mode = "Manual"
    else:
        mode = "Autonomous"
    log_file.write(mode+"\n")

def listener():
    rospy.init_node('data_listener', anonymous=True)

    rospy.Subscriber("va", Float64, callback_va)
    rospy.Subscriber("twist_msg", Twist, callback_pid)
    rospy.Subscriber("vt", Float64, callback_vt)

    rospy.spin()

def initializer():
    log_file = open("~/log_data/"+time.strftime("%H:%M")+"_"+time.strftime("%d/%m/%y")+".txt", "a")
    log_file.write("Logging Data for"+time.strftime("%H:%M")+" "+time.strftime("%d/%m/%y")+".\n")
    log_file.write("Time\t\tActual Velocity\t\tTarget Velocity\t\tMode")

    listener()

if __name__ == '__main__':
    initializer()