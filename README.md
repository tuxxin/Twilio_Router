# 📞 Twilio Smart Call Router (PHP)
**Developed by [Tuxxin.com](https://tuxxin.com)**

A lightweight, logic-driven PHP router for **Twilio Programmable Voice**. This script acts as a dynamic TwiML (Twilio Markup Language) generator that manages incoming calls based on business hours, US Federal holidays, and simultaneous ringing requirements.

---

## 🚀 Features

* **⏰ Business Hours Logic:** Automatically detects if a call is placed within your defined "Open" window (e.g., 9:00 AM – 5:00 PM EST).
* **Automated US Holiday Closure:** * **Fixed Dates:** New Year's, Juneteenth, Independence Day, etc.
    * **Floating Holidays:** Smart calculation for holidays like Labor Day, Thanksgiving, and Memorial Day (e.g., "Last Monday of May").
* **📠 Automated Voicemail:** Routes callers to a recording service with custom text-to-speech announcements when the office is closed.
* **🔔 Simultaneous Ringing:** Rings multiple numbers at once during business hours, ensuring the first available agent can pick up.

---

## 🛠️ Configuration

To customize this for your own business, simply modify the variables at the top of the script:

### 1. Operation Hours
Change the `$openTime` and `$closeTime` variables to match your schedule.

```php
// Business hours setup
$openTime = '09:00';
$closeTime = '17:00';
```

### 2. Forwarding Numbers
Add your team's phone numbers in the `<Dial>` section near the bottom of the script.

```xml
<Dial>
    <Number>123-4567</Number>
    <Number>123-4568</Number>
</Dial>
```

---

## 📖 Deployment Instructions

1.  **Host the script:** Upload the PHP file to a publicly accessible web server (must support PHP 7.4+).
2.  **Point Twilio to your URL:**
    * Log in to your [Twilio Console](https://www.twilio.com/console).
    * Navigate to **Develop > Phone Numbers > Active Numbers**.
    * Click on your specific phone number.
    * Under the **Voice & Fax** section, set **"A CALL COMES IN"** to **Webhook**.
    * Paste your script URL (e.g., `https://yourdomain.com/twilio-router.php`) and ensure the method is set to **HTTP POST**.
3.  **Test:** Call your Twilio number during and after business hours to verify the routing logic.

---

## 📝 License

This project is provided "as-is" by **Tuxxin.com**. Please ensure you comply with Twilio's Terms of Service and local telecommunication regulations regarding call recording and privacy.
