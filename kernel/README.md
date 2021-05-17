Information I was able to find about Terramaster F4-210 NAS
* [System info (kernel version, openwrt version, opkg info, kernel command line)](current/system_info.txt)
* [Kernel params](current/kernel_params.txt)
* List of devices [lspci](current/lspci.txt)
* List of block devices [lsblk](current/lsblk.txt)
* List of USB devices [lsusb](current/lsusb.txt)
* [proc/devices](current/proc_devices.txt)
* List of [opkg packages](current/opkg-packages.txt)
* [MTD partitions](current/mtd.txt) - the same as in kernel command line - see [system_info]((current/system_info.txt))

# Dump of mtd partitions
```
dd if=/dev/mtd0ro of=mtd0_factory.bin bs=4096 count=32
dd if=/dev/mtd1ro of=mtd1_uboot.bin bs=4096 count=128
dd if=/dev/mtd2ro of=mtd2_logo.bin bs=4096 count=80
dd if=/dev/mtd3ro of=mtd3_afw.bin bs=4096 count=352
dd if=/dev/mtd4ro of=mtd4_dtb.bin bs=4096 count=16
dd if=/dev/mtd5ro of=mtd5_kernel.bin bs=4096 count=1920
dd if=/dev/mtd6ro of=mtd5_initrd.bin bs=4096 count=1408
```

```
size     position name
00020000 00000000 factory
00080000 00020000 uboot
00050000 000A0000 logo
00160000 000F0000 afw
00010000 00250000 dtb
00780000 00260000 kernel
00580000 009E0000 initrd
```

# firmware.img

```
$ binwalk firmware.img 

DECIMAL       HEXADECIMAL     DESCRIPTION
--------------------------------------------------------------------------------
0             0x0             LZMA compressed data, properties: 0x6D, dictionary size: 8388608 bytes, uncompressed size: 8294400 bytes
327680        0x50000         LZMA compressed data, properties: 0x6D, dictionary size: 8388608 bytes, uncompressed size: 913328 bytes
1769472       0x1B0000        Flattened device tree, size: 59310 bytes, version: 17
1835008       0x1C0000        LZMA compressed data, properties: 0x6D, dictionary size: 1048576 bytes, uncompressed size: 17186064 bytes
9699328       0x940000        xz compressed data
```

Looks like firmware.img contains 5 parts of flash RAM: logo, afw, dtb, kernel, initrd
