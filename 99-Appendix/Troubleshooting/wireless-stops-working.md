# Latitude E6XXX Series Wireless Troubleshooting 
## Wireless Card Does not Show Up in Settings

### Perform an initial connection check
Open Terminal Window, type ``nmcli device`` and press Enter

Open a Terminal window, type ``lshw -C network`` and press Enter. If this gives an error message, you may need to install the lshw program on your computer.

Look through the information that appeared and find the Wireless interface section. If your wireless adapter was detected properly, you should see something similar (but not identical) to this:
```
    *-network
           description: Wireless interface
           product: PRO/Wireless 3945ABG [Golan] Network Connection
           vendor: Intel Corporation
```
If a wireless device is listed, continue on to the Device Drivers step.

### Device Drivers step
Check to see if your wireless adapter is on a list of supported devices.

	430-3960 : Dell Wireless 1530 802.11a/b/g /n Half Mini Card, Dell Latitude E6420

Most Linux distributions keep a list of wireless devices that they have support for. Sometimes, these lists provide extra information on how to get the drivers for certain adapters working properly. Go to the list for your distribution (for example, Ubuntu, Arch, Fedora or openSUSE) and see if your make and model of wireless adapter is listed. You may be able to use some of the information there to get your wireless drivers working.

Look for restricted (binary) drivers.

Many Linux distributions only come with device drivers which are free and open source. This is because they cannot distribute drivers which are proprietary, or closed-source. If the correct driver for your wireless adapter is only available in a non-free, or “binary-only” version, it may not be installed by default. If this is the case, look on the wireless adapter manufacturer’s website to see if they have any Linux drivers.

Some Linux distributions have a tool that can download restricted drivers for you. If your distribution has one of these, use it to see if it can find any wireless drivers for you.

### If a wireless device is not listed;
Open a Terminal, type ``lspci`` and press Enter.

Look through the list of devices that is shown and find any that are marked Network controller or Ethernet controller. Several devices may be marked in this way; the one corresponding to your wireless adapter might include words like wireless, WLAN, wifi or 802.11. Here is an example of what the entry might look like:

    Network controller: Intel Corporation PRO/Wireless 3945ABG [Golan] Network Connection

If you found your wireless adapter in the list, proceed to the Device Drivers step. If you didn’t find anything related to your wireless adapter, see the instructions below.



### Common issue not only with with Broadcom network adapters but other network adapters as well in Ubuntu Linux.

If possible
    • Plug into LAN/Ethernet

Open Software & Updates
    • Input your password and reload the software sources.
    • Go in the Additional Drivers tab
    • Select the propriety wireless driver
```
e.g.
Broadcom Limited: BCM43XX 802.11ac Wireless Network Adapter
This devide is not working
Using 802.11 Linux STA wireless driver source from bcmwl-kernel-source (proprietary)
**(Selected)** Do not use the device
```
Select the radio button:
Using 802.11 Linux STA wireless driver source from bcmwl-kernel-source (proprietary)

    • Apply Changes

![Broadcom Wireless](/img/troubleshooting/broadcom_wireless.jpg)

### Once the drivers have been installed, you’ll see that Ubuntu now recognizes the wireless networks in range. Should now read;

Broadcom Limited: BCM43XX 802.11ac Wireless Network Adapter
This devide is using an alternative driver
(Selected) Using 802.11 Linux STA wireless driver source from bcmwl-kernel-source (proprietary)
Do not use the device
