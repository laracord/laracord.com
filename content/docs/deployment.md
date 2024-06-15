---
slug: deployment
title: 'Deployment'
description: 'Bundle Laracord into a PHAR to run your Discord bot in production.'
priority: 4
group: 'Getting Started'
---

Building Laracord for production has the same build process as [Laravel Zero](https://laravel-zero.com/) utilizing [Box](https://github.com/box-project/box) to bundle the application into a single `PHAR` file.

Additional configuration for Box can be found in `box.json`.

## Building for Production

To build your bot for production, simply run the `app:build` command:

```sh
$ php laracord app:build
```

Once the build command completes, the bundled bot file with be located in `builds/`.

> #### Note
>
> For more information on `app:build`, you can refer to the [Laravel Zero docs](https://laravel-zero.com/docs/build-a-standalone-application).

## Booting in Production

When your bot is built for production, it will expect to live alongside a `.env` file and will automatically create a `database.sqlite` file and `cache` folder alongside the binary on first run.

To boot your bot, use the built `PHAR` file the same way you worked with Laracord locally on a server running PHP 8.1+:

```sh
$ php laracord
# or
$ ./laracord
```

## Pterodactyl Egg

If you are using Pterodactyl for existing applications/servers, you can easily run your Laracord bot using the officially supported [Pterodactyl egg](https://github.com/laracord/egg).

![Pterodactyl Screenshot](/images/pterodactyl.png)
