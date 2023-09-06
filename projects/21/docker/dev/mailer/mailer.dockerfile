# syntax=docker/dockerfile:experimental
ARG mailer_image
FROM $mailer_image AS mailer-common
