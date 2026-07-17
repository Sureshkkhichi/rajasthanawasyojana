<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Flat/Plot Allotment Letter</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 5px;">
        <h2 style="color: #d32f2f; border-bottom: 2px solid #d32f2f; padding-bottom: 10px; margin-top: 0;">
            Allotment Letter - {{ $project->name }}
        </h2>
        
        <p>Dear {{ $deal->first_name }} {{ $deal->last_name }},</p>
        
        <p>We are pleased to inform you that your flat/plot allotment in the <strong>{{ $project->name }}</strong> project has been successfully processed.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold; width: 40%;">Project Name</td>
                <td style="padding: 10px; border: 1px solid #ddd;">{{ $project->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Unit Assigned</td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    {{ $inventory->inventory_type === 'flat' ? 'Flat No: ' . $inventory->flat_no : 'Plot No: ' . $inventory->plot_no }}
                </td>
            </tr>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 10px; border: 1px solid #ddd; font-weight: bold;">Unit Type/Size</td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    {{ $inventory->inventory_type === 'flat' ? $inventory->flat_type : $inventory->area_sq_yards . ' Sq. Yards' }}
                </td>
            </tr>
        </table>
        
        <p>Please find the official <strong>Allotment Letter (आवंटन पत्र)</strong> attached to this email as a PDF document for your records.</p>
        
        <p>If you have any questions or require further assistance, feel free to contact us at {{ $project_contact_phone }}.</p>
        
        <hr style="border: 0; border-top: 1px solid #ddd; margin: 20px 0;">
        
        <p style="font-size: 12px; color: #777; margin-bottom: 0;">
            This is an automated email. Please do not reply directly to this message.
        </p>
    </div>
</body>
</html>
