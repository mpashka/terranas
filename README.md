# What is this
Collection of add-ons to make 
[terramaster F4-210 NAS](https://www.terra-master.com/us/products/homesoho-nas/f4-210.html)
more functional.


# Terranas F4-210 description
* SoC Realtek RTD1296 4x arm64 V8 Cortex-A53 1.4GHz
* Memory 1GB or 2GB DDR4 - not upgradable
* 4 Disk Slots (3.5" or 2.5" SATA) (5 connectors)
* 1Gb Ethernet
* 2xUSB 3.0
* 2xUSB 2.0 - soldered on the board, doesn't have external connector. One connector is 
  used by 256 MB flash drive used to boot up system.
* PCIe 4.0 with 5xSATA board installed
* Power: 12V DC 6A
* Size (H\*W\*D) - 227 x 225x 136 mm
* Net Weight: 2.25Kg
* OS: Based on OpenWrt Chaos Calmer 15.05.1 (revision r48422, no-all glibc busybox)
* Kernel: based on 4.4.18-g8bcbd8a-dirty
* OS Release: TOS 4.2.12-2104281637
* [Product information](https://www.terra-master.com/us/products/homesoho-nas/f4-210.html)
* [Official forum](https://forum.terra-master.com/en/index.php)
* [Official TOS download](https://support.terra-master.com/download/packages?product=F4-210)
* [Firmware download](https://forum.terra-master.com/en/viewtopic.php?f=75&t=696&sid=2e8ead4e56971ac5746353c6fe86d64d)
* [Photos](https://drive.google.com/drive/folders/1eQj4qI_QJrOEV6tIFl0UiBlMEKgG8rdo)
* [Saved downloads](https://drive.google.com/drive/folders/1oNhv_rqt5sSRDoS8HVc7HHRXaYsgglhv)

Motherboard has landing places for 2 extra LAN connectors, HDMI connector, and several 
other connectors, few switches and 2 microchips. Also J1 connector on the
mainboard is serial connector with 4 pin JST 2mm connector and pins as of [ZIDOO X9S](https://drive.google.com/file/d/1VVdpVPi_aK3qKlb6PJjlSa_LHUVrPk0L/view?usp=sharing)
which can be used to access SPI prompt (press ctrl+q before NAS turn on) or [u-boot console](uboot/README.md) (press Esc before NAS turn on).


# PCB microchips
* Memory chip 4x: SEC04b K4A4G16 E8SEEE90
* Flash RAM: winbond 25Q128JVSQ
* W45R 2227
* P-Channel enhancement mode power mosfet 3x: [3P7R0E 03627M](https://drive.google.com/file/d/1MJ2qHImw6wKAPJQ0lqrOCwq7A-XKP1CF/view)
* NBMM 675 042


# Other RTD1296 based products
There is good and open RTD1296 based product - 
[Banana Pi BPI-W2 board](http://www.banana-pi.org/w2.html)
([wiki](http://wiki.banana-pi.org/Banana_Pi_BPI-W2)). It has OpenWrt based firmware, 
Android firmware, Ubuntu, Debian, Raspbian, Aarch, OpenSUSE, Kali, RPiTC based firmware

Set of RTD1296 based android video boxes by [zidoo](https://www.zidoo.tv/):
* [Z9s](https://www.zidoo.tv/Product/index/model/Z9S/target/2INlOr7QH%2B1KKmVViAFMcQ%3D%3D.html)
* [Z10](https://www.zidoo.tv/Product/index/model/Z10/target/7kv1voas1D1KKmVViAFMcQ%3D%3D.html)

Several [synology](https://www.synology.com/) products -
[check this list](https://www.synology.com/en-us/knowledgebase/DSM/tutorial/Compatibility_Peripherals/What_kind_of_CPU_does_my_NAS_have):
* DS420j
* DS220j
* RS819
* DS418
* DS418j
* DS218
* DS218play
* DS118

# [System info](kernel/README.md)

# [cdc-acm usb driver](kernel/cdc-acm-usbdriver.md)

# [uboot info](uboot/README.md)

# Other links
* [zidoo unbrick instructions](http://forum.zidoo.tv/index.php?threads/how-to-flash-zidoo-x9s-unit.2959/page-8#post-38299)
