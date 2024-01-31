---
slug: deployment
title: 'Deployment'
priority: 4
group: 'Getting Started'
---

Building Laracord for production has the same build process as [Laravel Zero](https://laravel-zero.com/) utilizing [box](https://github.com/box-project/box) to bundle the application into a single `PHAR` file.

When your bot is built for production, it will expect to live alongside a `.env` file and will automatically create a `database.sqlite` and `cache` folder alongside the binary on first run.

## Building for Production

To build your bot for production, simply run the `app:build` command:

```sh
$ php laracord app:build
```

Additional configuration for box can be found in `box.json`.

For more information on `app:build`, you can refer to the [Laravel Zero docs](https://laravel-zero.com/docs/build-a-standalone-application).
