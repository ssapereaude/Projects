/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import javax.swing.ImageIcon;
import javax.swing.JFrame;
import javax.swing.JLabel;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.WindowEvent;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.util.Calendar;
import java.util.Date;
import java.util.GregorianCalendar;
import utils.Colors;
import utils.DB;
import utils.Fonts;
import utils.User;
import utils.classes.MysteryBox;

public class MysteryBoxFrame extends JFrame implements ActionListener {

    private final int WIDTH = 600;
    private final int HEIGHT = 600;

    JLabel box;
    Button btn;
    JLabel info;
    MysteryBox mysteryBox;
    JFrame frame;
    boolean isOpened = false;

    private void savePrize(int amount) {
        Connection connection = null;
        PreparedStatement pstat = null;

        try {
            connection = DriverManager.getConnection(DB.URL, DB.USER, DB.PASSWORD);

            /* create mystery box record */
            pstat = connection.prepareStatement("INSERT INTO mysterybox (username, amount) VALUES (?,?)");
            pstat.setString(1, User.getUsername());
            pstat.setInt(2, amount);
            pstat.executeUpdate();

            /* update user balance */
            pstat = connection.prepareStatement(
                    "UPDATE users SET balance = balance + ?, nextMysteryBox = DATE_ADD(CURDATE(), INTERVAL 1 DAY) WHERE username = ?");
            pstat.setInt(1, amount);
            /* pstat.setDate(2, LocalDateTime.from(new Date().toInstant()).plusDays(1)); */
            pstat.setString(2, User.getUsername());
            pstat.executeUpdate();
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
    }

    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == btn) {
            if (isOpened) {
                this.dispatchEvent(new WindowEvent(this, WindowEvent.WINDOW_CLOSING));
            } else {
                int prize = mysteryBox.open();
                savePrize(prize);
                isOpened = true;
                box.setIcon(null);
                box.setFont(Fonts.PRIZE);
                box.setForeground(Colors.TEXT);
                box.setText("€ " + prize);

                Date date = new Date();
                Calendar calendar = GregorianCalendar.getInstance();
                calendar.setTime(date);
                int hours = 24 - calendar.get(Calendar.HOUR_OF_DAY);
                int minutes = 60 - calendar.get(Calendar.MINUTE);

                if (minutes == 60) {
                    minutes = 0;
                } else {
                    hours--;
                }

                info.setText("Next Mystery Box in " + hours + "h " + minutes + "min");

                btn.setText("OK");
            }
        }
    }

    public MysteryBoxFrame() {
        mysteryBox = new MysteryBox();
        frame = this;

        this.setTitle("Daily Mystery Box");
        this.setSize(WIDTH, HEIGHT);
        this.setResizable(false);
        this.setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        this.getContentPane().setBackground(Colors.BG);
        this.setLayout(null);
        ImageIcon img = new ImageIcon("images/box.png");
        this.setIconImage(img.getImage());
        this.setVisible(true);

        box = new JLabel(new ImageIcon("images/box.png"));
        box.setBackground(Colors.BG);
        box.setBounds(200, 150, 200, 200);
        this.add(box);

        btn = new Button("Open", this);
        btn.setFont(Fonts.DEFAULT);
        btn.setForeground(Colors.BG);
        btn.setBackground(Colors.PRIMARY);
        btn.setBounds(200, 450, 200, 45);
        btn.addActionListener(this);
        this.add(btn);

        info = new JLabel();
        info.setBackground(Colors.BG);
        info.setForeground(Colors.LABEL);
        info.setFont(Fonts.AVATAR);
        info.setBounds(0, 380, 600, 40);
        info.setHorizontalAlignment(0);
        this.add(info);
    }

}
