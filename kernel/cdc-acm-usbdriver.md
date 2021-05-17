# TL;DR [Zigbee kernel module for Terramaster F4-210 NAS]()
* Enable ssh access on your NAS
* Connect to your NAS through ssh
* Start root session: `sudo su -` and enter your password to gain root access (shell prompt must change from `$` to `#`)
* Download this module and put it into `/lib/modules/4.4.18-g8bcbd8a-dirty`: 
  `ter_wget _TBD_ -O /lib/modules/4.4.18-g8bcbd8a-dirty/cdc-acm.ko`.
* Install module by applying command `modprobe cdc-acm`. If everything is ok then nothing is printed. 
  If your stick is plugged then new device appears `ls -l /dev/ttyACM0`. And in this case you are ready to run 
  zigbee2mqtt. 
* If anything goes wrong you get the following message
```
1 module could not be probed
- cdc-acm
```
In order to find out the reason you have to check kernel messages by applying command `dmesg -T`.


# Instructions to build cdc-acm usb driver for terramaster F4-210 NAS
* This is applicable only for Linux or any other system that can run `make` for linux kernel 
  (e.g. `cygwin` or MacOS). In order to build module you need several dependencies installed (most probably 
  `m4`, `autoconf`, `automake`, `libtool`, `make`, `g++`, `gpp`). Another solution is to run the whole thing in 
  `docker` - e.g. [sinovoip/bpi-build-linux](https://hub.docker.com/r/sinovoip/bpi-build-linux-4.4/):
    * `docker pull sinovoip/bpi-build-linux-4.4:ubuntu16.04`
    * `docker run -it --rm -v _local_src_path_:/usr/src -v _local_toolchain_path_:/usr/toolchain sinovoip/bpi-build-linux-4.4:ubuntu16.04`
* Download 4.4.8 kernel sources from [here](https://cdn.kernel.org/pub/linux/kernel/v4.x/linux-4.4.18.tar.gz)
  and unpack (`tar -xvf linux-4.4.18.tar.gz`)
* Download [patch](kernel_patch.diff), change current current dir to `linux-4.4.18/` - `cd linux-4.4.18`
  and apply `patch < /path/to/downloaded/patch/file`. This applies patch to rename `__copy_to_user` -> `__arch_copy_to_user`
  and adds ARCH_RTD129x platfrom support into `arch/arm64/Kconfig.platforms`
* Run `make menuconfig` to create default config, exit, save it and then run `make ARCH=x86_64 scripts` to create
  build scripts. If you see `error: code model kernel does not support PIC mode` during compilation then check 
  [Apply PIC patch]() section
* Put [arm64 config](.config) into `linux-4.4.18/` dir
* Download aarch64 toolchain. In order to use appropriate toolchain you have to provide prefix either by applying
  `CROSS_COMPILE=_prefix_` parameter to make or specifying `CONFIG_CROSS_COMPILE` parameter in `.config`. If your 
  toolchain is in PATH you can specify just prefix - e.g. `aarch64-linux-gnu-` for `gcc-aarch64-linux-gnu` or
  with full path e.g. `/opt/toolchains/aarch64-linaro/bin/aarch64-linux-gnu-`.
  * Initially I've tried `gcc-aarch64-linux-gnu` from my
    current ubuntu distribution (`Ubuntu 21.04`). Install it by applying `sudo apt-get install --install-recommends gcc-aarch64-linux-gnu`
    and use ```aarch64-linux-gnu-` cross compile prefix. 
  * [Linaro](https://developer.arm.com/tools-and-software/open-source-software/developer-tools/gnu-toolchain/gnu-a/downloads).
    I assume in order to compile on x86_64 host you have to download `x86_64 Linux hosted cross compilers` -> 
    `AArch64 GNU/Linux target (aarch64-none-linux-gnu)`
  * I used Linaro GCC 7.3-2018.05 from the [raspberry pi BPI-W2-bsp](https://github.com/BPI-SINOVOIP/BPI-W2-bsp) - check
    `toolchains/gcc-linaro-7.3.1-2018.05-x86_64_aarch64-linux-gnu/bin` dir.
* Run `make ARCH=arm64 [CROSS_COMPILE=_gcc-prefix_] prepare`
* Run `make ARCH=arm64 [CROSS_COMPILE=_gcc-prefix_] M=drivers/usb/class` to build driver. If everything is ok your driver
  will be located in `drivers/usb/class/cdc-acm.ko`.


# Apply PIC patch
This step is needed if you see error like this: `code model kernel does not support PIC mode`.
There is an issue -
[kernel doesn't support PIC mode for compiling](https://askubuntu.com/questions/851433/kernel-doesnt-support-pic-mode-for-compiling).
This is applicable for gcc 6+ versions where PIE (position independent executables) is enabled by default.
In order to fix apply this [makefile patch](makefile_patch_pie.diff).


# Zigbee and default NAS kernel
I have zigbee texas instruments cc2531 based stick to run my home assistant.
Use [homeassistant](https://www.home-assistant.io/) as a core,
[zigbee2mqtt](https://www.zigbee2mqtt.io/) as zigbee stick driver,
[mosquitto](https://mosquitto.org/) as mqtt broker - channel between homeassistant and zigbee2mqtt.
In order to support zigbee cc2531 stick and run zigbee2mqtt we need cdc-acm usb driver.
Driver is present in main kernel source. But during kernel compilation I've found
that there is incongruity. I've asked [question on stack overflow](https://stackoverflow.com/questions/67525731/error-unknown-symbol-copy-to-user-during-module-load)
with detailed description.

So the problem is:
Using cdc-acm compiled against kernel 4.4.8 reported the following error:
```
cdc_acm: Unknown symbol __copy_to_user (err 0)
cdc_acm: Unknown symbol __copy_from_user (err 0)
```

And current NAS kernel instead contains:
```bash
# cat /proc/kallsyms | grep copy_to_user
ffffff80082923f0 T copy_to_user_page
ffffff80087d2600 T __arch_copy_to_user
```

I googled for `__arch_copy_to_user` and found that it was introduced in 
[kernel 4.8](https://elixir.bootlin.com/linux/v4.8/A/ident/__arch_copy_to_user).

But on the other hand kernel 4.8 also introduced 
[moving function `cdc_parse_cdc_header`](https://elixir.bootlin.com/linux/v4.8/A/ident/cdc_parse_cdc_header)
to drivers/usb/core/message.c
[from drivers/net/usb/usbnet.c](https://elixir.bootlin.com/linux/v4.7/A/ident/cdc_parse_cdc_header)
And our kernel doesn't have it.

So looks like current NAS kernel source is a mix of different kernel versions. So in order to get working 
cdc-acm driver I had to modify kernel sources manually.

Also I added `ARCH_RTD129x` by applying `arch/arm64/Kconfig.platforms` value from newer build.

Note: I will try to ask Terramaster about providing kernel sources they used to build firmware. 
At the end they have to provide sources since they are licensed by GNU GPL.


# Kernel configuration
Here is list of parameters I changed:
 * Platform selection -> Realtek RTD129x SoC Family
 * Enable loadable module support -> [-] Module versioning support (because our kernel doesn't have it)
 * Kernel hacking -> [-] Tracers (because otherwise _mcount() function is used and our kernel doesn't have it)
 * Kernel Features -> Preemption Model -> No Forced Preemption (Server) (because our kernel doesn't have it)
 * Local version -> -g8bcbd8a-dirty
