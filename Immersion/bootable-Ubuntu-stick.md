
# Bootable Ubuntu USB Stick 

With a bootable Ubuntu USB stick, you can:

* Install or upgrade Ubuntu
* Test out the Ubuntu desktop experience without touching your PC configuration
* Boot into Ubuntu on a borrowed machine or from an internet cafe
* Use tools installed by default on the USB stick to repair or fix a broken configuration

## Requirements

* A 4GB or larger USB stick/flash drive
* Ubuntu Desktop 14.04 or later installed
* An Ubuntu ISO file. See [Get Ubuntu](https://ubuntu.com/download?_ga=2.6339632.363647871.1594139826-51890878.1594139826) for download links

![Bionic Download](/img/bootable-Ubuntu-stick/bionic-download.png)

## Launch Startup Disk Creator

We’re going to use an application called ‘Startup Disk Creator’ to write the ISO image to your USB stick. This is installed by default on Ubuntu, and can be launched as follows:

1. Insert your USB stick (select ‘Do nothing’ if prompted by Ubuntu)
2. On Ubuntu 18.04 and later, use the bottom left icon to open ‘Show Applications’
3. In older versions of Ubuntu, use the top left icon to open the dash
4. Use the search field to look for Startup Disk Creator
5. Select Startup Disk Creator from the results to launch the application

![Bionic Search Apps](/img/bootable-Ubuntu-stick/bionic-search-apps.png)

## ISO and USB selection

When launched, Startup Disk Creator will look for the ISO files in your Downloads folder, as well as any attached USB storage it can write to.

It’s likely that both your Ubuntu ISO and the correct USB device will have been detected and set as ‘Source disc image’ and ‘Disk to use’ in the application window. If not, use the ‘Other’ button to locate your ISO file and select the exact USB device you want to use from the list of devices.

Click `Make Startup Disk` to start the process.

![Bionic Make Start Up Disk](/img/bootable-Ubuntu-stick/bionic-make-startup-disk.png)

## Confirm USB device

Before making any permanent changes, you will be asked to confirm the USB device you’ve chosen is correct. This is important because any data currently stored on this device will be destroyed.

After confirming, the write process will start and a progress bar appears.

![Bionic Progress](/img/bootable-Ubuntu-stick/bionic-usb-progress.png)

## Installation complete

That’s it! You now have Ubuntu on a USB stick, bootable and ready to go.

![Bionic Complete](/img/bootable-Ubuntu-stick/bionic-usb-complete.png)

## References
1. [Ubuntu Stick Tutorial](https://ubuntu.com/tutorials/create-a-usb-stick-on-ubuntu#1-overview)
2. [Get Ubuntu](https://ubuntu.com/download?_ga=2.6339632.363647871.1594139826-51890878.1594139826)
3. [Install Ubuntu desktop tutorial](https://ubuntu.com/tutorials/install-ubuntu-desktop#1-overview)
