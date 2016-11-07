#!/usr/bin/env python
import rospy
from std_msgs.msg import String
from std_msgs.msg import Float64
from geometry_msgs.msg import Twist
import time
import csv  

global vel_actual
global vel_target
global mode
global pid_output
global log_file

def callback_va(data, args):
    vel_actual = data.data
    log_file = args
    log_file.write(time.strftime("%H:%M")+"\t\t"+str(vel_actual)+"\t\t\n")
    rospy.loginfo("Writing Data")

def callback_vt(data, args):
    vel_target = data.data
    log_file = args
    log_file.write(str(vel_target)+"\t\t")

def callback_pid(data, args):
    pid_output = data.linear.x
    log_file = args
    if data.angular.y==1:
        mode = "Manual"
    else:
        mode = "Autonomous"
    log_file.write(str(pid_output)+"\t\t"mode+"\n")

def listener(log_file):
    rospy.init_node('data_listener', anonymous=True)

    rospy.Subscriber("va", Float64, callback_va, log_file)
    rospy.Subscriber("vt", Float64, callback_vt, log_file)
    rospy.Subscriber("twist_msg", Twist, callback_pid, log_file)

    rospy.spin()

def initializer():
    log_file = open("../log_files/"+time.strftime("%d-%m-%y")+".txt", "a")
    log_file.write("*--------Logging Data for "+time.strftime("%H:%M:%S")+" "+time.strftime("%d/%m/%y")+"-------------*\n")
    log_file.write("Time\t\tActual Velocity\t\tTarget Velocity\t\tGiven DAC\t\tMode\n\n")

    listener(log_file)

if __name__ == '__main__':
    initializer()