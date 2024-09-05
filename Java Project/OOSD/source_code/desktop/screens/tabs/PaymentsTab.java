/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens.tabs;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import javax.swing.JFileChooser;
import javax.swing.JFrame;
import javax.swing.JLabel;
import javax.swing.JPanel;
import components.Button;
import components.PaymentRecord;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;
import utils.Window;
import utils.classes.Payment;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedWriter;
import java.io.FileWriter;

public class PaymentsTab extends Tab implements ActionListener {

    private final String[] LABELS = { "Date", "Time", "Amount" };
    private final int[] OFFSET_X = { 20, 200, 380 };

    JPanel table;
    Button saveBtn;
    Payment[] payments;
    int noOfPayments;
    JLabel[] labels;
    PaymentRecord[] records;

    private void saveAllPayments(String folderPath) {
        Connection connection = null;
        PreparedStatement pstat = null;
        BufferedWriter writer = null;
        ResultSet resultSet = null;

        String[] dateTime;
        String amount;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement(
                    "SELECT timestamp, balanceUP FROM payments WHERE username = ? AND isSuccessfull = 1 ORDER BY timestamp DESC");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();

            String filePath = folderPath + "\\payments_"
                    + new SimpleDateFormat("yyyy_MM_dd").format(Calendar.getInstance().getTime()) + ".csv";
            writer = new BufferedWriter(new FileWriter(filePath));

            writer.write(LABELS[0] + "," + LABELS[1] + "," + LABELS[2] + "\n");

            while (resultSet.next()) {
                dateTime = resultSet.getObject(1).toString().split(" ");
                if (dateTime[1].indexOf('.') > 0) {
                    dateTime[1] = dateTime[1].substring(0, dateTime[1].indexOf('.'));
                } else {
                    dateTime[1] = dateTime[1];
                }

                amount = resultSet.getObject(2).toString();
                amount += 00;
                amount = "€ " + amount.substring(0, amount.indexOf('.') + 3);

                writer.write(dateTime[0] + "," + dateTime[1] + "," + amount + "\n");

            }
        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                writer.close();
                pstat.close();
                connection.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }
    }

    private Payment[] fetchPayments() {
        Payment[] payments = new Payment[9];

        Connection connection = null;
        PreparedStatement pstat = null;
        ResultSet resultSet = null;

        String[] dateTime;
        String amount;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);
            pstat = connection.prepareStatement(
                    "SELECT timestamp, balanceUP as amount FROM payments WHERE username = ? AND isSuccessfull = 1 ORDER BY timestamp DESC LIMIT 9");
            pstat.setString(1, User.getUsername());

            resultSet = pstat.executeQuery();

            int i = 0;

            while (resultSet.next()) {
                dateTime = resultSet.getObject(1).toString().split(" ");
                amount = resultSet.getObject(2).toString();

                payments[i] = new Payment(dateTime[0], dateTime[1], amount);

                noOfPayments++;
                i++;
            }

        } catch (Exception e) {
            e.printStackTrace();
        } finally {
            try {
                pstat.close();
                connection.close();
            } catch (Exception e) {
                e.printStackTrace();
            }
        }

        return payments;
    }

    public void actionPerformed(ActionEvent ev) {

        if (ev.getSource() == saveBtn) {
            JFileChooser fileChooser = new JFileChooser();
            fileChooser.setDialogTitle("Select folder");
            fileChooser.setFileSelectionMode(JFileChooser.DIRECTORIES_ONLY);

            int userSelection = fileChooser.showSaveDialog(new JFrame());

            if (userSelection == JFileChooser.APPROVE_OPTION) {
                String folderPath = fileChooser.getSelectedFile().getAbsolutePath();
                saveAllPayments(folderPath);
            }
        }

    }

    public PaymentsTab() {
        super("Recent Payments");

        table = new JPanel();
        table.setBackground(Colors.BG);
        table.setBounds(PADDING_X, PADDING_Y + TITLE_HEIGHT + 30, 660, 490);
        table.setLayout(null);

        labels = new JLabel[3];
        for (int i = 0; i < 3; i++) {
            labels[i] = new JLabel(LABELS[i]);
            labels[i].setBounds(OFFSET_X[i], 0, 180, 40);
            labels[i].setBackground(Colors.BG);
            labels[i].setForeground(Colors.LABEL);
            labels[i].setFont(Fonts.LABEL);
            table.add(labels[i]);

        }

        payments = fetchPayments();

        records = new PaymentRecord[noOfPayments];
        String[] row = new String[3];

        for (int i = 0; i < noOfPayments; i++) {
            row[0] = payments[i].getDate();
            row[1] = payments[i].getTime();
            row[2] = payments[i].getAmount();
            records[i] = new PaymentRecord(row, OFFSET_X, 660, 50, i % 2 == 1 ? Colors.BG : Colors.BG_LIGHT);
            records[i].setBounds(0, 40 + i * 50, 660, 50);
            table.add(records[i]);
        }

        this.add(table);

        saveBtn = new Button("Save all as CSV");
        saveBtn.setBackground(Colors.PRIMARY);
        saveBtn.setForeground(Colors.BG);
        saveBtn.setFont(Fonts.DEFAULT);
        saveBtn.setBounds(WIDTH - PADDING_X - 200, Window.WINDOW_HEIGHT - PADDING_Y - 60, 200, 46);
        saveBtn.addActionListener(this);
        this.add(saveBtn);
    }

}
